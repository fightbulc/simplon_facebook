<?php

namespace Simplon\Facebook\Post;

use Simplon\Facebook\FacebookConstants;
use Simplon\Facebook\FacebookException;
use Simplon\Facebook\FacebookRequests;
use Simplon\Facebook\Post\Vo\FacebookPostVo;
use Simplon\Helper\CastAway;
use Simplon\Helper\Helper;

/**
 * FacebookPosts
 * @package Simplon\Facebook\Post
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class FacebookPosts
{
    /**
     * @param string $accessToken
     * @param string $edgeId
     * @param FacebookPostVo $facebookPostVo
     *
     * @return string
     * @throws FacebookException
     */
    public function create($accessToken, $edgeId, FacebookPostVo $facebookPostVo)
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_POST_EDGE],
            ['edgeId' => $edgeId],
            ['access_token' => $accessToken]
        );

        $response = FacebookRequests::post($url, $facebookPostVo->toArray());

        if (empty($response['id']) === false)
        {
            return CastAway::toString($response['id']);
        }

        throw new FacebookException('Could not create post');
    }

    /**
     * @param string $accessToken
     * @param FacebookPostVo $facebookPostVo
     *
     * @return bool
     * @throws FacebookException
     */
    public function update($accessToken, FacebookPostVo $facebookPostVo)
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_GRAPH_ITEM],
            ['id' => $facebookPostVo->getId()],
            ['access_token' => $accessToken]
        );

        $response = FacebookRequests::post($url, $facebookPostVo->toArray());

        if (empty($response['success']) === false)
        {
            return true;
        }

        throw new FacebookException('Could not update post');
    }

    /**
     * @param string $accessToken
     * @param string $postId
     *
     * @return bool
     * @throws FacebookException
     */
    public function delete($accessToken, $postId)
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_GRAPH_ITEM],
            ['id' => $postId],
            ['access_token' => $accessToken]
        );

        $response = FacebookRequests::delete($url);

        if (empty($response['success']) === false)
        {
            return true;
        }

        throw new FacebookException('Could not delete post');
    }
}