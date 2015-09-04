<?php

namespace Simplon\Facebook\Event;

use Simplon\Facebook\FacebookConstants;
use Simplon\Facebook\FacebookException;
use Simplon\Facebook\FacebookRequests;
use Simplon\Helper\Helper;

/**
 * Class FacebookEvents
 * @package Simplon\Facebook\Event
 */
class FacebookEvents
{
    /**
     * @param string $accessToken
     * @param string $eventId
     * @param array $fields
     *
     * @return array
     * @throws FacebookException
     */
    public function read($accessToken, $eventId, array $fields = ['id', 'name', 'description', 'cover'])
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_GRAPH_ITEM],
            ['id' => $eventId],
            [
                'access_token' => $accessToken,
                'fields'       => join(',', $fields),
            ]
        );

        $response = FacebookRequests::get($url);

        if (empty($response['id']) === false)
        {
            return $response;
        }

        throw new FacebookException('Could not fetch event data');
    }
}