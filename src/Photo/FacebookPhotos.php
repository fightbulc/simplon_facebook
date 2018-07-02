<?php

namespace Simplon\Facebook\Photo;

use Simplon\Facebook\App\FacebookApps;
use Simplon\Facebook\FacebookConstants;
use Simplon\Facebook\FacebookException;
use Simplon\Facebook\FacebookRequests;
use Simplon\Facebook\Photo\Data\PhotoCreateData;
use Simplon\Facebook\Photo\Data\PhotoCreateResponseData;

/**
 * @package Simplon\Facebook\Photo
 */
class FacebookPhotos
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
     * @param string          $accessToken
     * @param string          $edgeId
     * @param PhotoCreateData $photoCreateData
     *
     * @return PhotoCreateResponseData
     * @throws FacebookException
     */
    public function create(string $accessToken, string $edgeId, PhotoCreateData $photoCreateData): PhotoCreateResponseData
    {
        $placeholders = ['edge_id' => $edgeId];

        $queryParams = [
            'access_token' => $accessToken,
            'app_secret'   => $this->app->getSecret(),
        ];

        $path = FacebookRequests::buildPath(FacebookConstants::PATH_PHOTO_EDGE, $placeholders, $queryParams);

        $response = FacebookRequests::post($path, $photoCreateData->toArray());

        if (empty($response['id']) === false)
        {
            return (new PhotoCreateResponseData())->fromArray($response);
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
    public function delete(string $accessToken, string $photoId): bool
    {
        $placeholders = ['id' => $photoId];

        $queryParams = [
            'access_token' => $accessToken,
            'app_secret'   => $this->app->getSecret(),
        ];

        $response = FacebookRequests::delete(
            FacebookRequests::buildPath(FacebookConstants::PATH_GRAPH_ITEM, $placeholders, $queryParams)
        );

        if (empty($response['success']) === false)
        {
            return true;
        }

        throw new FacebookException('Could not delete photo');
    }
}