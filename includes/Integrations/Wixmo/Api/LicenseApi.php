<?php
namespace Trefik\Integrations\Wixmo\Api;
defined('ABSPATH') || exit;

use \WP_ERROR;

class LicenseApi extends ApiBase {

    /**
     * @param array $data payload: firstName, lastName, email, licenseId, validityDays
     */
    public function extend_validity_days(array $data): array|WP_Error {
        $required = [ 'firstName', 'lastName', 'email', 'licenseId', 'validityDays' ];

        foreach ( $required as $key ) {
            if ( ! array_key_exists( $key, $data ) || $data[ $key ] === '' || $data[ $key ] === null ) {
                return new WP_Error( 'trefik_wixmo_license_missing_field', "Missing required field: {$key}" );
            }
        }

        return $this->post( '/licenses/' . $data['licenseId'] . '/_extend-validity-days', $data, [
            'Content-Type' => 'application/json',
        ], true );
    }
}
