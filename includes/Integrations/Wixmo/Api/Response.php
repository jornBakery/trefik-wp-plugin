<?php
namespace Trefik\Wixmo\Api;

/**
 * Base class for the response of the API
 *
 */
class Response
{
    protected $data = array();

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getRequest()
    {
        return $this->data['request'];
    }

    /**
     * Get the complete response as an array
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
