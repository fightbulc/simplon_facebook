<?php

namespace Simplon\Facebook\Photo;

use Simplon\Facebook\Core\FacebookConstants;
use Simplon\Facebook\Core\FacebookRequests;
use Simplon\Facebook\Photo\Vo\FacebookPhotoVo;

/**
 * Class FacebookPhotos
 * @package Simplon\Facebook\Photo
 */
class FacebookPhotos
{
    /**
     * @param string $accessToken
     * @param string $objectId
     * @param FacebookPhotoVo $facebookPhotoVo
     *
     * @return int|null
     */
    public function create($accessToken, $objectId, FacebookPhotoVo $facebookPhotoVo)
    {
        $requestUrl = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            FacebookRequests::renderPath(FacebookConstants::PATH_PHOTO_CREATE, ['parentObjectId' => $objectId]),
            ['access_token' => $accessToken]
        );

        $response = FacebookRequests::publish($requestUrl, $facebookPhotoVo->toArray());

        if (isset($response['id']) === false)
        {
            return null;
        }

        // --------------------------------------

        return (int)$response['id'];
    }

    /**
     * @param string $accessToken
     * @param string $photoId
     *
     * @return bool|null
     */
    public function delete($accessToken, $photoId)
    {
        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            FacebookRequests::renderPath(FacebookConstants::PATH_OBJECT, ['id' => $photoId]),
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