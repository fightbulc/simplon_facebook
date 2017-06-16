<?php

namespace Simplon\Facebook\Event;

use Simplon\Facebook\FacebookConstants;
use Simplon\Facebook\FacebookException;
use Simplon\Facebook\FacebookRequests;

/**
 * @package Simplon\Facebook\Event
 */
class FacebookEvents
{
    /**
     * @param $accessToken
     * @param $eventId
     * @param array $fields
     *
     * @return array
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function read($accessToken, $eventId, array $fields = ['id', 'name', 'description', 'cover'])
    {
        $placeholders = ['id' => $eventId];
        $queryParams = [
            'access_token' => $accessToken,
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