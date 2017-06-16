<?php

namespace Simplon\Facebook;

use Simplon\Request\Request;
use Simplon\Request\RequestResponse;
use Simplon\Url\Url;

/**
 * @package Simplon\Facebook
 */
class FacebookRequests
{
    /**
     * @param string $path
     * @param array $params
     *
     * @return array
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public static function get(string $path, array $params = []): array
    {
        return self::handleResponse(
            (new Request())->get(self::buildGraphUrl($path), $params)
        );
    }

    /**
     * @param string $path
     * @param array $params
     *
     * @return array
     * @throws FacebookException
     */
    public static function post(string $path, array $params = []): array
    {
        return self::handleResponse(
            (new Request())->post(self::buildGraphUrl($path), $params)
        );
    }

    /**
     * @param string $path
     * @param array $params
     *
     * @return array
     * @throws FacebookException
     */
    public static function delete(string $path, array $params = []): array
    {
        return self::handleResponse(
            (new Request())->delete(self::buildGraphUrl($path), $params)
        );
    }

    /**
     * @param string $path
     * @param array $placeholders
     * @param array $queryParams
     *
     * @return string
     */
    public static function buildPath(string $path, array $placeholders = [], array $queryParams = []): string
    {
        if (!empty($placeholders))
        {
            foreach ($placeholders as $key => $val)
            {
                $path = str_replace('{' . $key . '}', $val, $path);
            }
        }

        if (!empty($queryParams))
        {
            $path = (new Url($path))->withQueryParams($queryParams)->__toString();
        }

        return $path;
    }

    /**
     * @param string $path
     *
     * @return Url
     */
    public static function buildGraphUrl(string $path): Url
    {
        return (new Url(FacebookConstants::URL_GRAPH))
            ->withPath('v' . FacebookConstants::getVersion())
            ->withTrailPath($path)
            ;
    }

    /**
     * @param string $path
     *
     * @return Url
     */
    public static function buildFacebookUrl(string $path): Url
    {
        return (new Url(FacebookConstants::URL_FACEBOOK))->withTrailPath($path);
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