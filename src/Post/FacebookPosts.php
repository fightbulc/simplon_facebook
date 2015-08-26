<?php

namespace Simplon\Facebook\Post;

use Simplon\Facebook\Core\FacebookConstants;
use Simplon\Facebook\Core\FacebookRequests;
use Simplon\Facebook\Post\Vo\FacebookPostVo;

/**
 * FacebookPosts
 * @package Simplon\Facebook\Post
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class FacebookPosts
{
    /**
     * @param string $accessToken
     * @param string $parentObjectId
     * @param FacebookPostVo $facebookPostVo
     *
     * @return null|string
     */
    public function create($accessToken, $parentObjectId, FacebookPostVo $facebookPostVo)
    {
        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            FacebookRequests::renderPath(FacebookConstants::PATH_POST_CREATE, ['parentObjectId' => $parentObjectId]),
            ['access_token' => $accessToken]
        );

        $response = FacebookRequests::publish($url, $facebookPostVo->toArray());

        if (isset($response['id']) === false)
        {
            return null;
        }

        // --------------------------------------

        return (string)$response['id'];
    }

    /**
     * @param string $accessToken
     * @param string $postId
     * @param FacebookPostVo $facebookPostVo
     *
     * @return bool
     */
    public function update($accessToken, $postId, FacebookPostVo $facebookPostVo)
    {
        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            FacebookRequests::renderPath(FacebookConstants::PATH_OBJECT, ['postId' => $postId]),
            ['access_token' => $accessToken]
        );

        $response = FacebookRequests::publish($url, $facebookPostVo->toArray());

        return (bool)$response['success'];
    }

    /**
     * @param string $accessToken
     * @param string $postId
     *
     * @return bool|null
     */
    public function delete($accessToken, $postId)
    {
        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            FacebookRequests::renderPath(FacebookConstants::PATH_OBJECT, ['postId' => $postId]),
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