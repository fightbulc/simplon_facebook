<?php

namespace Simplon\Facebook;

use Simplon\Request\Request;
use Simplon\Request\RequestResponse;

/**
 * Class FacebookRequests
 * @package Simplon\Facebook
 */
class FacebookRequests
{
    /**
     * @param string $url
     * @param array $params
     *
     * @return array
     */
    public static function get($url, array $params = [])
    {
        return self::handleResponse(
            (new Request())->get($url, $params)
        );
    }

    /**
     * @param string $url
     * @param array $params
     *
     * @return array
     */
    public static function post($url, array $params = [])
    {
        return self::handleResponse(
            (new Request())->post($url, $params)
        );
    }

    /**
     * @param string $url
     * @param array $params
     *
     * @return array
     */
    public static function delete($url, array $params = [])
    {
        return self::handleResponse(
            (new Request())->delete($url, $params)
        );
    }

    /**
     * @param string $response
     *
     * @return array
     */
    private static function parseResponse($response)
    {
        // try json
        $data = json_decode($response, true);

        // get data from string if NOT-JSON response
        if (is_null($data) === true)
        {
            $data = [];
            parse_str($response, $data);
        }

        return (array)$data;
    }

    /**
     * @param RequestResponse $response
     *
     * @return array
     * @throws FacebookException
     */
    private static function handleResponse(RequestResponse $response)
    {
        // parse response
        $data = self::parseResponse($response->getBody());

        // handle error response
        if (isset($data['error']) === true)
        {
            self::handleErrorResponse($data);
        }

        return $data;
    }

    /**
     * @param array $response
     *
     * @throws FacebookException
     */
    private static function handleErrorResponse(array $response)
    {
        if (empty($response['error']))
        {
            $response = ['error' => []];
        }

        throw new FacebookException(
            'Request error occurred',
            FacebookConstants::ERROR_CODE_REQUEST,
            $response['error']
        );
    }
}