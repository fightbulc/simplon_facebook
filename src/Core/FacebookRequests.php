<?php

namespace Simplon\Facebook\Core;

use Simplon\Request\Request;
use Simplon\Request\RequestResponse;

/**
 * FacebookRequests
 * @package Simplon\Facebook\Core
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class FacebookRequests
{
    /**
     * @param string $url
     * @param array  $requestParams
     *
     * @return array
     */
    public static function read($url, array $requestParams = [])
    {
        return self::handleResponse(
            Request::get($url, $requestParams)
        );
    }

    /**
     * @param string $url
     * @param array  $requestParams
     *
     * @return array
     */
    public static function publish($url, array $requestParams = [])
    {
        return self::handleResponse(
            Request::post($url, $requestParams)
        );
    }

    /**
     * @param string $url
     * @param array  $requestParams
     *
     * @return array
     */
    public static function delete($url, array $requestParams = [])
    {
        return self::handleResponse(
            Request::delete($url, $requestParams)
        );
    }

    /**
     * @param string $url
     * @param string $path
     * @param array  $getParams
     *
     * @return string
     */
    public static function renderUrl($url, $path, array $getParams = [])
    {
        $url = trim($url, '/') . '/' . trim($path, '/');

        if (empty($getParams) === false)
        {
            $url = $url . '?' . http_build_query($getParams);
        }

        return $url;
    }

    /**
     * @param string $path
     * @param array  $pathParams
     *
     * @return mixed|string
     */
    public static function renderPath($path, array $pathParams = [])
    {
        $path = trim($path, '/');

        foreach ($pathParams as $key => $val)
        {
            $path = str_replace('{{' . $key . '}}', $val, $path);
        }

        return $path;
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
     * @throws FacebookErrorException
     */
    private static function handleResponse(RequestResponse $response)
    {
        // parse response
        $data = self::parseResponse($response->getContent());

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
     * @throws FacebookErrorException
     */
    private static function handleErrorResponse(array $response)
    {
        throw new FacebookErrorException(
            FacebookConstants::ERROR_REQUEST_CODE,
            FacebookConstants::ERROR_REQUEST_EXCEPTION_SUBCODE,
            FacebookConstants::ERROR_REQUEST_EXCEPTION_MESSAGE,
            isset($response['error']) ? $response['error'] : []
        );
    }
}