<?php

namespace Simplon\Facebook\Core;

/**
 * FacebookErrorException
 * @package Simplon\Facebook\Core
 * @author Tino Ehrich (tino@bigpun.me)
 */
class FacebookErrorException extends \Exception
{
    /**
     * @var array
     */
    protected $errors;

    /**
     * @var int
     */
    protected $subcode;

    /**
     * @param int $code
     * @param int $subcode
     * @param string $message
     * @param array $errors
     */
    public function __construct($code = 0, $subcode = 0, $message = '', $errors = [])
    {
        $this->code = $code;
        $this->subcode = $subcode;
        $this->message = $message;
        $this->errors = $errors;
    }

    /**
     * @return string
     */
    public function getSubcode()
    {
        return (string)$this->subcode;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return (array)$this->errors;
    }

    /**
     * @return array
     */
    public function getDataArray()
    {
        return [
            'code'    => $this->getCode(),
            'subcode' => $this->getSubcode(),
            'message' => $this->getMessage(),
            'errors'  => $this->getErrors(),
        ];
    }

    /**
     * @return string
     */
    public function getDataJson()
    {
        return json_encode($this->getDataArray());
    }
}