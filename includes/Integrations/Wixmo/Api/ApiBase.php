<?php
namespace Trefik\Integrations\Wixmo\Api;

use Trefik\Core\Config;
use \WP_ERROR;

defined('ABSPATH') || exit;
/**
 * Base class for Tref-ik API calls.
 * - Fetches OAuth2 client_credentials token from Keycloak
 * - Caches token (transient)
 * - Provides request helpers (GET/POST/PUT/DELETE)
 */
abstract class ApiBase {

    /** @var string Token endpoint (Keycloak / OIDC) */
    protected string $token_url = '';

    /** @var string API base URL (child can override) */
    protected string $api_base_url = '';

    /** @var string Client credentials */
    protected string $client_id;
    protected string $client_secret;
    protected string $grant_type;

    /** @var string transient key (can be unique per env/site) */
    protected string $token_transient_key = 'trefik_wixmo_api_access_token';

    /** @var int seconds to subtract from expires_in to avoid edge expiry */
    protected int $expiry_skew_seconds = 30;

    public function __construct(
        ?string $client_id = null,
        ?string $client_secret = null,
        ?string $api_base_url = null,
        ?string $token_url = null,
        ?string $grant_type = null
    ) {
        $cid = Config::get('wixmo.client_id');
        $csec = Config::get('wixmo.client_secret');

        $this->client_id = $client_id ?? ( $cid !== null ? (string) $cid : '' );
        $this->client_secret = $client_secret ?? ( $csec !== null ? (string) $csec : '' );
        $this->grant_type = $grant_type ?? (string) Config::get('wixmo.grant_type');
        $this->token_url = $token_url ?? (string) Config::get('wixmo.token_url');

        $base = $api_base_url ?? (string) Config::get('wixmo.api_base_url');
        $this->api_base_url = rtrim($base, '/');
    }

    /**
     * Public helper: force token refresh
     */
    public function refresh_access_token(): string|WP_Error {
        delete_transient($this->token_transient_key);
        return $this->fetch_access_token();
    }

    /**
     * Core request method
     */
    protected function request(string $method, string $path, array $options = []): array|WP_Error {
        $method = strtoupper($method);

        $url = $this->build_url($path);

        $token = $options['auth'] ?? true;
        $headers = $options['headers'] ?? [];
        $query   = $options['query'] ?? [];
        $body    = $options['body'] ?? null;       // array|string|null
        $json    = $options['json'] ?? true;       // if true and body is array => json encode
        $timeout = $options['timeout'] ?? 20;

        if (!empty($query)) {
            $url = add_query_arg($query, $url);
        }

        if ($token) {
            $access_token = $this->get_access_token();
            if (is_wp_error($access_token)) {
                return $access_token;
            }
            $headers['Authorization'] = 'Bearer ' . $access_token;
        }

        // Default accept header
        if (!isset($headers['Accept'])) {
            $headers['Accept'] = 'application/json';
        }

        $args = [
            'method'  => $method,
            'timeout' => (int) $timeout,
            'headers' => $headers,
        ];

        if ($body !== null) {
            // If body is array and json=true => JSON encode
            if (is_array($body) && $json) {
                $args['headers']['Content-Type'] = $args['headers']['Content-Type'] ?? 'application/json';
                $args['body'] = wp_json_encode($body);
            } else {
                // raw string or form body array
                $args['body'] = $body;
            }
        }

        $response = wp_remote_request($url, $args);

        if (is_wp_error($response)) {
            return $response;
        }

        $status = (int) wp_remote_retrieve_response_code($response);
        $raw    = (string) wp_remote_retrieve_body($response);

        $decoded = null;
        if ($raw !== '') {
            $decoded = json_decode($raw, true);
        }

        if ($status < 200 || $status >= 300) {
            $message = 'API request failed';
            if (is_array($decoded)) {
                $message = $decoded['message']
                    ?? $decoded['error_description']
                    ?? $decoded['error']
                    ?? $message;
            }

            return new WP_Error(
                'trefik_wixmo_api_http_error',
                $message,
                [
                    'status' => $status,
                    'url'    => $url,
                    'raw'    => $raw,
                    'json'   => $decoded,
                ]
            );
        }

        // Return decoded JSON if possible; otherwise raw wrapper
        if (is_array($decoded)) {
            return $decoded;
        }

        return ['raw' => $raw];
    }

    protected function get(string $path, array $query = [], array $headers = []): array|WP_Error {
        return $this->request('GET', $path, [
            'query'   => $query,
            'headers' => $headers,
        ]);
    }

    protected function post(string $path, array|string|null $body = null, array $headers = [], bool $json = true): array|WP_Error {
        return $this->request('POST', $path, [
            'body'    => $body,
            'headers' => $headers,
            'json'    => $json,
        ]);
    }

    protected function put(string $path, array|string|null $body = null, array $headers = [], bool $json = true): array|WP_Error {
        return $this->request('PUT', $path, [
            'body'    => $body,
            'headers' => $headers,
            'json'    => $json,
        ]);
    }

    protected function delete(string $path, array|string|null $body = null, array $headers = [], bool $json = true): array|WP_Error {
        return $this->request('DELETE', $path, [
            'body'    => $body,
            'headers' => $headers,
            'json'    => $json,
        ]);
    }

    /**
     * Build absolute URL from base + path.
     * If $path is already absolute (https://...), return as-is.
     */
    protected function build_url(string $path): string {
        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }
        $base = rtrim($this->api_base_url, '/');
        $path = '/' . ltrim($path, '/');
        return $base . $path;
    }

    /**
     * Get cached access token or fetch new.
     */
    protected function get_access_token(): string|WP_Error {
        $cached = get_transient($this->token_transient_key);
        if (is_string($cached) && $cached !== '') {
            return $cached;
        }
        return $this->fetch_access_token();
    }

    /**
     * Fetch token from Keycloak token endpoint with x-www-form-urlencoded body.
     */
    protected function fetch_access_token(): string|WP_Error {
        if ($this->client_id === '' || $this->client_secret === '') {
            return new WP_Error(
                'trefik_wixmo_api_missing_credentials',
                'Wixmo API client credentials are not configured. Set TREFIK_WIXMO_API_CLIENT_ID and TREFIK_WIXMO_API_CLIENT_SECRET in wp-config.php or the environment.'
            );
        }

        $response = wp_remote_post($this->token_url, [
            'timeout' => 20,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept'       => 'application/json',
            ],
            'body' => [
                'client_id'     => $this->client_id,
                'client_secret' => $this->client_secret,
                'grant_type'    => $this->grant_type,
            ],
        ]);

        if (is_wp_error($response)) {
            return $response;
        }

        $status = (int) wp_remote_retrieve_response_code($response);
        $raw    = (string) wp_remote_retrieve_body($response);
        $json   = json_decode($raw, true);

        if ($status < 200 || $status >= 300) {
            $message = is_array($json)
                ? ($json['error_description'] ?? $json['error'] ?? 'Token request failed')
                : 'Token request failed';

            return new WP_Error('trefik_wixmo_api_token_error', $message, [
                'status' => $status,
                'raw'    => $raw,
                'json'   => $json,
            ]);
        }

        if (!is_array($json) || empty($json['access_token'])) {
            return new WP_Error('trefik_wixmo_api_token_parse_error', 'Token response missing access_token.', [
                'raw'  => $raw,
                'json' => $json,
            ]);
        }

        $token = (string) $json['access_token'];
        // Helper::write_log(["wixmo_access_token", $token]);
        // Cache based on expires_in (minus skew)
        $expires_in = isset($json['expires_in']) ? (int) $json['expires_in'] : 300;
        $ttl = max(30, $expires_in - $this->expiry_skew_seconds);
        set_transient($this->token_transient_key, $token, $ttl);

        return $token;
    }
}
