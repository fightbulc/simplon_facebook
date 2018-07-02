<?php

namespace Simplon\Facebook\Page;

use Simplon\Facebook\App\FacebookApps;
use Simplon\Facebook\FacebookConstants;
use Simplon\Facebook\FacebookException;
use Simplon\Facebook\FacebookRequests;
use Simplon\Facebook\Page\Data\PageData;
use Simplon\Facebook\Photo\Data\PhotoCreateData;
use Simplon\Facebook\Photo\FacebookPhotos;
use Simplon\Facebook\Post\Data\PostData;
use Simplon\Facebook\Post\FacebookPosts;
use Simplon\Helper\CastAway;
use Simplon\Helper\Data\InstanceData;
use Simplon\Helper\Instances;

/**
 * @package Simplon\Facebook\Page
 */
class FacebookPages
{
    /**
     * @var FacebookApps
     */
    private $app;
    /**
     * @var string
     */
    private $accessToken;
    /**
     * @var string
     */
    private $pageId;

    /**
     * @param FacebookApps $app
     */
    public function __construct(FacebookApps $app)
    {
        $this->app = $app;
    }

    /**
     * @return string
     * @throws FacebookException
     */
    public function getAccessToken(): string
    {
        if (empty($this->accessToken) === false)
        {
            return $this->accessToken;
        }

        throw new FacebookException('Missing page access token');
    }

    /**
     * @param string $accessToken
     *
     * @return FacebookPages
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;
        $this->pageId = $this->getFacebookApps()->getDebugTokenData($accessToken)->getProfileId();

        return $this;
    }

    /**
     * @return string
     * @throws FacebookException
     */
    public function getPageId()
    {
        if (empty($this->pageId) === false)
        {
            return CastAway::toString($this->pageId);
        }

        throw new FacebookException('Missing page id');
    }

    /**
     * To get a longer-lived page access token, exchange the
     * User access token for a long-lived one, as above, and
     * then request the Page token. The resulting page access
     * token will not have any expiry time.
     * @link https://developers.facebook.com/docs/facebook-login/access-tokens/#extending
     *
     * @return string
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function requestAccessToken()
    {
        $response = FacebookRequests::get(FacebookConstants::PATH_OAUTH_ACCESSTOKEN, [
            'client_id'     => $this->getFacebookApps()->getId(),
            'client_secret' => $this->getFacebookApps()->getSecret(),
            'grant_type'    => 'client_credentials',
        ]);

        if (empty($response['access_token']) === false)
        {
            return CastAway::toString($response['access_token']);
        }

        throw new FacebookException('Could not retrieve page access token');
    }

    /**
     * @return PageData
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function getPageData(): PageData
    {
        $placeholders = ['id' => $this->getPageId()];

        $queryParams = [
            'access_token' => $this->getAccessToken(),
            'app_secret'   => $this->app->getSecret(),
        ];

        $response = FacebookRequests::get(
            FacebookRequests::buildPath(FacebookConstants::PATH_GRAPH_ITEM, $placeholders, $queryParams)
        );

        return (new PageData())->fromArray($response);
    }

    /**
     * @param PostData $facebookPostVo
     *
     * @return string
     * @throws FacebookException
     */
    public function feedCreate(PostData $facebookPostVo): string
    {
        return $this->getFacebookPosts()->create($this->getAccessToken(), $this->getPageId(), $facebookPostVo);
    }

    /**
     * @param PostData $facebookPostVo
     *
     * @return bool
     * @throws FacebookException
     */
    public function feedUpdate(PostData $facebookPostVo): bool
    {
        return $this->getFacebookPosts()->update($this->getAccessToken(), $facebookPostVo);
    }

    /**
     * @param string $postId
     *
     * @return bool|null
     * @throws FacebookException
     */
    public function feedDelete(string $postId): ?bool
    {
        return $this->getFacebookPosts()->delete($this->getAccessToken(), $postId);
    }

    /**
     * @param PhotoCreateData $photo
     *
     * @return null|string
     * @throws FacebookException
     */
    public function photoCreate(PhotoCreateData $photo): ?string
    {
        return $this->getFacebookPhotos()->create($this->getAccessToken(), $this->getPageId(), $photo);
    }

    /**
     * @param string $photoId
     *
     * @return bool
     * @throws FacebookException
     */
    public function photoDelete(string $photoId): bool
    {
        return $this->getFacebookPhotos()->delete($this->getAccessToken(), $photoId);
    }

    /**
     * @param null|int $position
     *
     * @return bool
     * @throws FacebookException
     */
    public function addTab(?int $position = null): bool
    {
        $placeholders = ['page_id' => $this->getPageId()];

        $queryParams = [
            'access_token' => $this->getAccessToken(),
            'app_secret'   => $this->app->getSecret(),
        ];

        $path = FacebookRequests::buildPath(FacebookConstants::PATH_PAGE_TABS, $placeholders, $queryParams);

        $response = FacebookRequests::post($path, [
            'app_id'   => $this->getFacebookApps()->getId(),
            'position' => $position,
        ]);

        if (empty($response['success']) === false)
        {
            return true;
        }

        throw new FacebookException('Could not add tab to page');
    }

    /**
     * @return bool
     * @throws FacebookException
     */
    public function removeTab(): bool
    {
        $placeholders = ['page_id' => $this->getPageId()];

        $queryParams = [
            'access_token' => $this->getAccessToken(),
            'app_secret'   => $this->app->getSecret(),
        ];

        $path = FacebookRequests::buildPath(FacebookConstants::PATH_PAGE_TABS, $placeholders, $queryParams);

        $response = FacebookRequests::delete($path, [
            'tab' => 'app_' . $this->getFacebookApps()->getId(),
        ]);

        if (empty($response['success']) === false)
        {
            return true;
        }

        throw new FacebookException('Could not remove tab from page');
    }

    /**
     * @return FacebookApps
     */
    private function getFacebookApps(): FacebookApps
    {
        return $this->app;
    }

    /**
     * @return FacebookPosts
     */
    private function getFacebookPosts(): FacebookPosts
    {
        return Instances::cache(
            InstanceData::create(FacebookPosts::class)
        );
    }

    /**
     * @return FacebookPhotos
     */
    private function getFacebookPhotos(): FacebookPhotos
    {
        return Instances::cache(
            InstanceData::create(FacebookPhotos::class)
        );
    }
}