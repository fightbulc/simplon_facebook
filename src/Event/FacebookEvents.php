<?php

namespace Simplon\Facebook\Event;

use Simplon\Facebook\App\FacebookApps;
use Simplon\Facebook\FacebookConstants;
use Simplon\Facebook\FacebookException;
use Simplon\Facebook\FacebookRequests;
use Simplon\Request\RequestException;

/**
 * @package Simplon\Facebook\Event
 */
class FacebookEvents
{
    /**
     * @var FacebookApps;
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
     * @param string $accessToken
     * @param string $eventId
     * @param array  $fields
     *
     * @return array
     * @throws FacebookException
     * @throws RequestException
     */
    public function read(string $accessToken, string $eventId, array $fields = ['id', 'name', 'description', 'cover']): array
    {
        $placeholders = ['id' => $eventId];

        $queryParams = [
            'access_token' => $accessToken,
            'app_secret'   => $this->app->getSecret(),
            'fields'       => join(',', $fields),
        ];

        $response = FacebookRequests::get(
            FacebookRequests::buildPath(FacebookConstants::PATH_GRAPH_ITEM, $placeholders, $queryParams)
        );

        if (empty($response['id']) === false)
        {
            return $response;
        }

        throw new FacebookException('Could not fetch event data');
    }
}