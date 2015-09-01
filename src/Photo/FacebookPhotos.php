<?php

namespace Simplon\Facebook\Photo;

use Simplon\Facebook\FacebookConstants;
use Simplon\Facebook\FacebookException;
use Simplon\Facebook\FacebookRequests;
use Simplon\Facebook\Photo\Vo\FacebookPhotoVo;
use Simplon\Helper\CastAway;
use Simplon\Helper\Helper;

/**
 * Class FacebookPhotos
 * @package Simplon\Facebook\Photo
 */
class FacebookPhotos
{
    /**
     * @param string $accessToken
     * @param string $edgeId
     * @param FacebookPhotoVo $facebookPhotoVo
     *
     * @return null|string
     * @throws FacebookException
     */
    public function create($accessToken, $edgeId, FacebookPhotoVo $facebookPhotoVo)
    {
        $requestUrl = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_PHOTO_EDGE],
            ['edgeId' => $edgeId],
            ['access_token' => $accessToken]
        );

        $response = FacebookRequests::post($requestUrl, $facebookPhotoVo->toArray());

        if (empty($response['id']) === false)
        {
            return CastAway::toString($response['id']);
        }

        throw new FacebookException('Could not create photo');
    }

    /**
     * @param string $accessToken
     * @param string $photoId
     *
     * @return bool
     * @throws FacebookException
     */
    public function delete($accessToken, $photoId)
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_GRAPH_ITEM],
            ['id' => $photoId],
            ['access_token' => $accessToken]
        );

        $response = FacebookRequests::delete($url);

        if (empty($response['success']) === false)
        {
            return true;
        }

        throw new FacebookException('Could not delete photo');
    }
}