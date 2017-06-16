<?php

namespace Simplon\Facebook\Post;

use Simplon\Facebook\FacebookConstants;
use Simplon\Facebook\FacebookException;
use Simplon\Facebook\FacebookRequests;
use Simplon\Facebook\Photo\Data\PhotoData;
use Simplon\Facebook\Post\Data\PostData;
use Simplon\Helper\CastAway;

/**
 * @package Simplon\Facebook\Post
 */
class FacebookPosts
{
    /**
     * @param string $accessToken
     * @param string $edgeId
     * @param PostData $facebookPostData
     *
     * @return string
     * @throws FacebookException
     */
    public function create(string $accessToken, string $edgeId, PostData $facebookPostData): string
    {
        $placeholders = ['edge_id' => $edgeId];
        $queryParams = ['access_token' => $accessToken];
        $path = FacebookRequests::buildPath(FacebookConstants::PATH_POST_EDGE, $placeholders, $queryParams);

        $response = FacebookRequests::post($path, $facebookPostData->toArray());

        if (empty($response['id']) === false)
        {
            return CastAway::toString($response['id']);
        }

        throw new FacebookException('Could not create post');
    }

    /**
     * @param string $accessToken
     * @param string $id
     * @param array|null $fields
     *
     * @return PostData|PhotoData
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function read(string $accessToken, string $id, ?array $fields = null)
    {
        $placeholders = ['id' => $id];
        $queryParams = ['access_token' => $accessToken, 'metadata' => 1];

        if ($fields)
        {
            $queryParams['fields'] = implode(',', $fields);
        }

        $path = FacebookRequests::buildPath(FacebookConstants::PATH_GRAPH_ITEM, $placeholders, $queryParams);

        $response = FacebookRequests::get($path);

        if (empty($response['id']) === false)
        {
            $wrapper = $response['metadata']['type'] === 'photo' ? new PhotoData() : new PostData();

            return $wrapper->fromArray($response);
        }

        throw new FacebookException('Could not read post');
    }

    /**
     * @param string $accessToken
     * @param PostData $facebookPostData
     *
     * @return bool
     * @throws FacebookException
     */
    public function update(string $accessToken, PostData $facebookPostData): bool
    {
        $placeholders = ['id' => $facebookPostData->getId()];
        $queryParams = ['access_token' => $accessToken];
        $path = FacebookRequests::buildPath(FacebookConstants::PATH_GRAPH_ITEM, $placeholders, $queryParams);

        $response = FacebookRequests::post($path, $facebookPostData->toArray());

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
    public function delete(string $accessToken, string $postId): bool
    {
        $placeholders = ['id' => $postId];
        $queryParams = ['access_token' => $accessToken];

        $response = FacebookRequests::delete(
            FacebookRequests::buildPath(FacebookConstants::PATH_GRAPH_ITEM, $placeholders, $queryParams)
        );

        if (empty($response['success']) === false)
        {
            return true;
        }

        throw new FacebookException('Could not delete post');
    }
}