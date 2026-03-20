<?php
namespace Trefik\Integrations\Wixmo\Api;
defined('ABSPATH') || exit;

use \WP_ERROR;

class StudentApi extends ApiBase {

    protected string $api_base_url = TREFIK_WIXMO_API_BASE_URL;

    /**
     * Create student
     * @param array $data payload per API spec
     */
    public function create(array $data): array|WP_Error {
        // Basic sane defaults / validation
        $required = ['firstName','lastName','email',];
        // $required = ['type','userName','firstName','lastName','email','birthDate'];

        foreach ($required as $key) {
            if (!array_key_exists($key, $data) || $data[$key] === '' || $data[$key] === null) {
                return new WP_Error('trefik_wixmo_students_missing_field', "Missing required field: {$key}");
            }
        }

        // Ensure studyGroups is an array if provided
        if (isset($data['studyGroups']) && !is_array($data['studyGroups'])) {
            return new WP_Error('trefik_wixmo_students_invalid_studygroups', 'studyGroups must be an array of IDs.');
        }

        return $this->post('/students/_create', $data, [
            'Content-Type' => 'application/json',
        ], true);
    }

    /**
     * Convenience wrapper matching your example payload
     */
    public function create_student_from_fields(
        string $userName,
        string $firstName,
        string $lastName,
        string $email,
        string $birthDateYmd,
        array $studyGroups,
        array $extra = []
    ): array|WP_Error {
        $payload = array_merge([
            'type'                => 'STUDENT',
            'userName'            => $userName,
            'firstName'           => $firstName,
            'lastName'            => $lastName,
            'email'               => $email,
//             'phone'               => '',
//             'birthDate'           => '01-01-20000', // "YYYY-MM-DD"
//             'languageId'          => '',
            'studyGroups'         => $studyGroups,
//             'identificationNumber'=> null,
//             'locale'              => null,
            'hasToVerifyIdentity' => false,
            'hasLanguageSupport'  => true,
//             'supportLanguage'     => null,
        ], $extra);

        return $this->create($payload);
    }
}
