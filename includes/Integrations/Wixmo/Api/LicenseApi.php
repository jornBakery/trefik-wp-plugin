<?php
namespace Trefik\Integrations\Wixmo\Api;
defined('ABSPATH') || exit;

use \WP_ERROR;

class LicenseApi extends ApiBase {

    protected string $api_base_url = TREFIK_WIXMO_API_BASE_URL;

    /**
     * Create student
     * @param array $data payload per API spec
     */
    public function extend_validity_days(array $data): array|WP_Error {
        // Basic sane defaults / validation
        $required = ['firstName','lastName','email', 'licenseId', 'validityDays'];

        foreach ($required as $key) {
            if (!array_key_exists($key, $data) || $data[$key] === '' || $data[$key] === null) {
                return new WP_Error('trefik_wixmo_license_missing_field', "Missing required field: {$key}");
            }
        }

        return $this->post('/licenses/'.$data['licenseId'] .'/_extend-validity-days', $data, [
            'Content-Type' => 'application/json',
        ], true);
    }

//     /**
//      * Convenience wrapper matching your example payload
//      */
//     public function extend_validity_days_from_field(
//         string $userName,
//         string $firstName,
//         string $lastName,
//         string $email,
//         string $birthDateYmd,
//         array $studyGroups,
//         array $extra = []
//     ): array|WP_Error {
//         $payload = array_merge([
//             'type'                => 'STUDENT',
//             'userName'            => $userName,
//             'firstName'           => $firstName,
//             'lastName'            => $lastName,
//             'email'               => $email,
// //             'phone'               => '',
// //             'birthDate'           => '01-01-20000', // "YYYY-MM-DD"
// //             'languageId'          => '',
//             'studyGroups'         => $studyGroups,
// //             'identificationNumber'=> null,
// //             'locale'              => null,
//             'hasToVerifyIdentity' => false,
//             'hasLanguageSupport'  => true,
// //             'supportLanguage'     => null,
//         ], $extra);

//         return $this->create($payload);
//     }
}
