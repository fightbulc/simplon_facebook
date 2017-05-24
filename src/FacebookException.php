<?php

namespace Simplon\Facebook;

/**
 * Class FacebookException
 * @package Simplon\Facebook
 */
class FacebookException extends \Exception
{
    /**
     * @var array
     */
    protected $apiErrors;

    /**
     * @param string $message
     * @param int $code
     * @param array $apiErrors
     */
    public function __construct(string $message, int $code = 0, array $apiErrors = [])
    {
        $this->message = $message;
        $this->code = $code;
        $this->apiErrors = $apiErrors;
    }

    /**
     * @return array
     */
    public function getDataArray(): array
    {
        return [
            'code'    => $this->getCode(),
            'message' => $this->getMessage(),
            'errors'  => $this->apiErrors,
        ];
    }

    /**
     * @return string
     */
    public function getDataJson(): string
    {
        return json_encode($this->getDataArray());
    }
}