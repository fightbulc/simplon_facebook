<?php

namespace Simplon\Facebook\Page;

use Simplon\Facebook\App\FacebookApps;
use Simplon\Facebook\FacebookConstants;
use Simplon\Facebook\FacebookException;
use Simplon\Facebook\FacebookRequests;
use Simplon\Facebook\Page\Vo\FacebookPageVo;
use Simplon\Facebook\Post\FacebookPosts;
use Simplon\Facebook\Post\Vo\FacebookPostVo;
use Simplon\Helper\CastAway;
use Simplon\Helper\Helper;

/**
 * FacebookPages
 * @package Simplon\Facebook\Page
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class FacebookPages
{
    /**
     * @var FacebookApps
     */
    private $facebookApps;

    /**
     * @var FacebookPosts
     */
    private $facebookPosts;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var string
     */
    private $pageId;

    /**
     * @param FacebookApps $facebookApps
     * @param FacebookPosts $facebookPosts
     */
    public function __construct(FacebookApps $facebookApps, FacebookPosts $facebookPosts)
    {
        $this->facebookApps = $facebookApps;
        $this->facebookPosts = $facebookPosts;
    }

    /**
     * @return string
     * @throws FacebookException
     */
    public function getAccessToken()
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
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        // read page id from token
        $this->pageId = $this
            ->getFacebookApps()
            ->getDebugTokenVo($accessToken)
            ->getProfileId();

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
     * @param string $uriRedirect
     *
     * @return string
     */
    public function getUrlPageTabDialog($uriRedirect)
    {
        $params = [
            'app_id'       => $this->getFacebookApps()->getId(),
            'redirect_uri' => $uriRedirect,
        ];

        return Helper::urlRender(
            [FacebookConstants::URL_FACEBOOK, FacebookConstants::PATH_PAGETAB],
            $params
        );
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
     */
    public function requestAccessToken()
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_OAUTH_ACCESSTOKEN]
        );

        $params = [
            'client_id'     => $this->getFacebookApps()->getId(),
            'client_secret' => $this->getFacebookApps()->getSecret(),
            'grant_type'    => 'client_credentials',
        ];

        $response = FacebookRequests::get($url, $params);

        if (empty($response['access_token']) === false)
        {
            return (string)$response['access_token'];
        }

        throw new FacebookException('Could not retrieve page access token');
    }

    /**
     * @return FacebookPageVo
     * @throws FacebookException
     */
    public function getPageData()
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_GRAPH_ITEM],
            ['{{id}}' => $this->getPageId()],
            ['access_token' => $this->getAccessToken()]
        );

        $response = FacebookRequests::get($url);

        return (new FacebookPageVo())->setData($response);
    }

    /**
     * @param FacebookPostVo $facebookPostVo
     *
     * @return null|string
     */
    public function feedCreate(FacebookPostVo $facebookPostVo)
    {
        return $this
            ->getFacebookPosts()
            ->create(
                $this->getAccessToken(),
                $this->getPageId(),
                $facebookPostVo
            );
    }

    /**
     * @param FacebookPostVo $facebookPostVo
     *
     * @return bool
     */
    public function feedUpdate(FacebookPostVo $facebookPostVo)
    {
        return $this
            ->getFacebookPosts()
            ->update(
                $this->getAccessToken(),
                $facebookPostVo
            );
    }

    /**
     * @param string $postId
     *
     * @return bool|null
     */
    public function feedDelete($postId)
    {
        return $this
            ->getFacebookPosts()
            ->delete($this->getAccessToken(), $postId);
    }

    /**
     * @param null|int $position
     *
     * @return bool
     * @throws FacebookException
     */
    public function addTab($position = null)
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH . FacebookConstants::PATH_PAGE_TABS],
            ['pageId' => $this->getPageId()],
            ['access_token' => $this->getAccessToken()]
        );

        // tab params
        $params = [
            'app_id'   => $this->getFacebookApps()->getId(),
            'position' => $position,
        ];

        $response = FacebookRequests::post($url, $params);

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
    public function removeTab()
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_PAGE_TABS],
            ['pageId' => $this->getPageId()],
            ['access_token' => $this->getAccessToken()]
        );

        // tab params
        $params = [
            'tab' => 'app_' . $this->getFacebookApps()->getId(),
        ];

        $response = FacebookRequests::delete($url, $params);

        if (empty($response['success']) === false)
        {
            return true;
        }

        throw new FacebookException('Could not remove tab from page');
    }

    /**
     * @return FacebookApps
     */
    private function getFacebookApps()
    {
        return $this->facebookApps;
    }

    /**
     * @return FacebookPosts
     */
    private function getFacebookPosts()
    {
        return $this->facebookPosts;
    }
}