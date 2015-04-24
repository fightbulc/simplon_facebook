<?php

namespace Simplon\Facebook\Post;

use Simplon\Facebook\Core\FacebookConstants;
use Simplon\Facebook\Core\FacebookRequests;

/**
 * FacebookPosts
 * @package Simplon\Facebook\Post
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class FacebookPosts
{
    /**
     * @param string      $path
     * @param string      $accessToken
     * @param string      $message
     * @param null|string $link
     *
     * @return null|string
     */
    public function feedPublish($path, $accessToken, $message, $link = null)
    {
        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            $path,
            ['access_token' => $accessToken]
        );

        // message params
        $params = ['message' => $message];

        // add link if available
        if ($link !== null)
        {
            $params['link'] = $link;
        }

        $response = FacebookRequests::publish($url, $params);

        if (isset($response['id']) === false)
        {
            return null;
        }

        // --------------------------------------

        return (string)$response['id'];
    }

    /**
     * @param string      $accessToken
     * @param string      $postId
     * @param string      $message
     * @param null|string $link
     *
     * @return bool
     */
    public function feedUpdate($accessToken, $postId, $message, $link = null)
    {
        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            FacebookRequests::renderPath(FacebookConstants::PATH_POST, ['postId' => $postId]),
            ['access_token' => $accessToken]
        );

        // message params
        $params = ['message' => $message];

        // add link if available
        if ($link !== null)
        {
            $params['link'] = $link;
        }

        $response = FacebookRequests::publish($url, $params);

        return (bool)$response['success'];
    }

    /**
     * @param string $accessToken
     * @param string $postId
     *
     * @return bool|null
     */
    public function feedRemove($accessToken, $postId)
    {
        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            FacebookRequests::renderPath(FacebookConstants::PATH_POST, ['postId' => $postId]),
            ['access_token' => $accessToken]
        );

        $response = FacebookRequests::delete($url);

        if (isset($response['success']) === false)
        {
            return null;
        }

        // --------------------------------------

        return true;
    }
}