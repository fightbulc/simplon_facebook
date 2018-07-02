<?php

namespace Simplon\Facebook\Objects;

use Simplon\Facebook\App\FacebookApps;
use Simplon\Facebook\FacebookConstants;
use Simplon\Facebook\FacebookException;
use Simplon\Facebook\FacebookRequests;
use Simplon\Facebook\Objects\Data\ObjectData;

/**
 * @package Simplon\Facebook\Objects
 */
class FacebookObjects
{
    /**
     * @var FacebookApps
     */
    private $app;

    /**
     * @param FacebookApps $app
     */
    public function __construct(FacebookApps $app)
    {
        $this->app = $app;
    }

    /**
     * @param string     $id
     * @param array|null $fields
     *
     * @return null|ObjectData
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function read(string $id, ?array $fields = null): ?ObjectData
    {
        $queryParams = [
            'id'           => $id,
            'access_token' => $this->app->getAppAccessToken(),
            'app_secret'   => $this->app->getSecret(),
        ];

        if ($fields)
        {
            $queryParams['fields'] = implode(',', $fields);
        }

        $response = FacebookRequests::get(FacebookConstants::PATH_OBJECT, $queryParams);

        if (isset($response['id']))
        {
            return new ObjectData($response);
        }

        return null;
    }

    /**
     * @param string $url
     *
     * @return ObjectData
     * @throws FacebookException
     */
    public function createCrawl(string $url): ObjectData
    {
        return $this->crawl($url);
    }

    /**
     * @param string $objectId
     *
     * @return ObjectData
     * @throws FacebookException
     */
    public function updateCrawl(string $objectId): ObjectData
    {
        return $this->crawl($objectId);
    }

    /**
     * @param string $object
     *
     * @return null|ObjectData
     * @throws FacebookException
     */
    protected function crawl(string $object): ?ObjectData
    {
        $placeholders = [];

        $queryParams = [
            'id'           => $object,
            'scrape'       => true,
            'access_token' => $this->app->getAppAccessToken(),
            'app_secret'   => $this->app->getSecret(),
        ];

        $response = FacebookRequests::post(
            FacebookRequests::buildPath(FacebookConstants::PATH_OBJECT, $placeholders, $queryParams)
        );

        if (isset($response['id']))
        {
            return new ObjectData($response);
        }

        return null;
    }
}