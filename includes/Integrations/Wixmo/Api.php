<?php
// namespace Trefik\Wixmo;

// use Curl\Curl;
// use Trefik\Config;
// use Trefik\Helper;
// use Trefik\Wixmo\Api\Error;

// class Api {

//     protected static $__instance;
//     protected static $auth_token;

//     /**
//      * @var array
//      */
//     protected $data = array();

//     public function __construct() {
//         if(!$__instance) {
//             $__instance = $this;
//         }
//         return $__instance;
//     }

//     protected function get($path) {

//     }

//     protected function post($path, $data) {

//     }

//     protected function getAuth() {
//         /** @var Curl $curl */
//         $curl = Config::getCurl();

//         // if (!empty($authToken)) {
//         //     $curl->setBasicAuthentication($auth['username'], $auth['password']);
//         // }      
//         $uri = Config::get_wixmo_auth_url();
//         $data = [
//             'client_id' => Config::get_wixmo_client_id(),
//             'client_secret' => Config::get_wixmo_api_key(),
//             'grant_type' => Config::get_wixmo_grant_type(),
//         ];
//         $curl->setOpt(CURLOPT_SSL_VERIFYPEER, true);
//         $curl->setOpt(CURLOPT_HTTPHEADER, [
//             'Content-Type: application/x-www-form-urlencoded',
//         ]);
//         $curl->setopt(CURLOPT_HEADER, true);    

//         // $curl->setOpt(CURLOPT_)
//         $result = $curl->post($uri, $data);
//         $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        
//         if (isset($result->status) && $result->status === 'FALSE') {
//             throw new Error\Api($result->error);
//         }      

//         if ($curl->error) {
//             throw new Error\Error($curl->errorMessage);
//         }
        
//         return $this->processResult($result);
//     }

//     /**
//      * @param object|array $result
//      *
//      * @return array
//      * @throws Error\Api
//      */
//     protected function processResult($result)
//     {
//         $output = Helper::objectToArray($result);

//         if (! is_array($output)) {
//             throw new Error\Api($output);
//         }

//         // if (isset($output['result'])) {
//         //     return $output;
//         // }

//         if (
//             isset($output['request']) &&
//             $output['request']['result'] != 1 &&
//             $output['request']['result'] !== 'TRUE') {
//             throw new Error\Api($output['request']['errorId'] . ' - ' . $output['request']['errorMessage']);
//         }

//         return $output;
//     }

//     /**
//      * @return array
//      * @throws Error\Required
//      */
//     protected function getData()
//     { 
//         return $this->data;
//     }

// }



// use Trefik\Helper;


    // /**
    //  * @param $endpoint
    //  * @param null|int $version
    //  *
    //  * @return array
    //  *
    //  * @throws Error\Api
    //  * @throws Error\Error
    //  * @throws Error\Required\ApiToken
    //  */
    // public function doRequest($endpoint, $version = null)
    // {
    //     if ($version === null) {
    //         $version = $this->version;
    //     }

    //     $auth = $this->getAuth();
    //     $data = $this->getData();
    //     $uri = Config::getApiUrl($endpoint, (int) $version);

    //     /** @var Curl $curl */
    //     $curl = Config::getCurl();

    //     if (Config::getCAInfoLocation()) {
    //         // set a custom CAInfo file
    //         $curl->setOpt(CURLOPT_CAINFO, Config::getCAInfoLocation());
    //     }

    //     if (!empty($auth)) {
    //         $curl->setBasicAuthentication($auth['username'], $auth['password']);
    //     }      
        
    //     $curl->setOpt(CURLOPT_SSL_VERIFYPEER, Config::getVerifyPeer());

    //     $result = $curl->post($uri, $data);
        
    //     if (isset($result->status) && $result->status === 'FALSE') {
    //         throw new Error\Api($result->error);
    //     }      

    //     if ($curl->error) {
    //         throw new Error\Error($curl->errorMessage);
    //     }
        
    //     return $this->processResult($result);
    // }

    
    // /**
    //  * @return array|null
    //  * @throws Error\Required\ApiToken
    //  */
    // private function getAuth()
    // {
    //     if (!$this->isApiTokenRequired()) {
    //         return null;
    //     }

    //     Helper::requireApiToken();
    //     $tokenCode = Config::getTokenCode();
    //     $apiToken = Config::getApiToken();
    //     if (!$tokenCode) {
    //         $this->data['token'] = $apiToken;
    //         return null;
    //     }
    //     return array('username' => $tokenCode, 'password' => $apiToken);
    // }

//     /**
//      * @return bool
//      */
//     public function isApiTokenRequired()
//     {
//         return $this->apiTokenRequired;
//     }

//     /**
//      * @return bool
//      */
//     public function isServiceIdRequired()
//     {
//         return $this->serviceIdRequired;
//     }

//     /**
//      * @param object|array $result
//      *
//      * @return array
//      * @throws Error\Api
//      */
//     protected function processResult($result)
//     {
//         $output = Helper::objectToArray($result);

//         if (! is_array($output)) {
//             throw new Error\Api($output);
//         }

//         if (isset($output['result'])) {
//             return $output;
//         }

//         if (
//             isset($output['request']) &&
//             $output['request']['result'] != 1 &&
//             $output['request']['result'] !== 'TRUE') {
//             throw new Error\Api($output['request']['errorId'] . ' - ' . $output['request']['errorMessage']);
//         }

//         return $output;
//     }
// }
