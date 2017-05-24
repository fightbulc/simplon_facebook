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
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public static function get(string $url, array $params = []): array
    {
        return self::handleResponse(
            (new Request())->get(self::replaceApiVersion($url), $params)
        );
    }

    /**
     * @param string $url
     * @param array $params
     *
     * @return array
     * @throws FacebookException
     */
    public static function post(string $url, array $params = []): array
    {
        return self::handleResponse(
            (new Request())->post(self::replaceApiVersion($url), $params)
        );
    }

    /**
     * @param string $url
     * @param array $params
     *
     * @return array
     * @throws FacebookException
     */
    public static function delete(string $url, array $params = []): array
    {
        return self::handleResponse(
            (new Request())->delete(self::replaceApiVersion($url), $params)
        );
    }

    /**
     * @param string $url
     *
     * @return string
     */
    private static function replaceApiVersion(string $url): string
    {
        return str_replace('{api-version-string}', 'v' . FacebookConstants::getVersion(), $url);
    }

    /**
     * @param string $response
     *
     * @return array
     */
    private static function parseResponse(string $response): array
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
    private static function handleResponse(RequestResponse $response): array
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