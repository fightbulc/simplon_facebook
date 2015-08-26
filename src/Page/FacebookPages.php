<?php

namespace Simplon\Facebook\Page;

use Simplon\Facebook\Core\FacebookConstants;
use Simplon\Facebook\Core\FacebookRequests;
use Simplon\Facebook\Page\Vo\FacebookPageVo;
use Simplon\Facebook\Post\FacebookPosts;
use Simplon\Facebook\Post\Vo\FacebookPostVo;

/**
 * FacebookPages
 * @package Simplon\Facebook\Page
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class FacebookPages
{
    /**
     * @var FacebookPosts
     */
    private $facebookPosts;

    /**
     * @param FacebookPosts $facebookPosts
     */
    public function __construct(FacebookPosts $facebookPosts)
    {
        $this->facebookPosts = $facebookPosts;
    }

    /**
     * To get a longer-lived page access token, exchange the
     * User access token for a long-lived one, as above, and
     * then request the Page token. The resulting page access
     * token will not have any expiry time.
     * @link https://developers.facebook.com/docs/facebook-login/access-tokens/#extending
     *
     * @param $pageAccessToken
     * @param $urlname
     *
     * @return FacebookPageVo
     */
    public function getPageData($pageAccessToken, $urlname)
    {
        $response = FacebookRequests::read(
            FacebookRequests::renderPath(FacebookConstants::PATH_PAGE_DATA, ['{{pageId}}' => $urlname]),
            ['access_token' => $pageAccessToken]
        );

        return (new FacebookPageVo())->setData($response);
    }

    /**
     * @param string $pageAccessToken
     * @param string $pageId
     * @param FacebookPostVo $facebookPostVo
     *
     * @return null|string
     */
    public function feedCreate($pageAccessToken, $pageId, FacebookPostVo $facebookPostVo)
    {
        return $this
            ->getFacebookPosts()
            ->create($pageAccessToken, $pageId, $facebookPostVo);
    }

    /**
     * @param string $pageAccessToken
     * @param string $postId
     * @param FacebookPostVo $facebookPostVo
     *
     * @return bool
     */
    public function feedUpdate($pageAccessToken, $postId, FacebookPostVo $facebookPostVo)
    {
        return $this
            ->getFacebookPosts()
            ->update($pageAccessToken, $postId, $facebookPostVo);
    }

    /**
     * @param string $pageAccessToken
     * @param string $postId
     *
     * @return bool|null
     */
    public function feedDelete($pageAccessToken, $postId)
    {
        return $this
            ->getFacebookPosts()
            ->delete($pageAccessToken, $postId);
    }

    /**
     * @param string $pageAccessToken
     * @param int $pageId
     * @param int $appId
     * @param null|int $position
     *
     * @return bool|null
     */
    public function addTab($pageAccessToken, $pageId, $appId, $position = null)
    {
        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            FacebookRequests::renderPath(FacebookConstants::PATH_PAGE_TABS, ['pageId' => $pageId]),
            ['access_token' => $pageAccessToken]
        );

        // tab params
        $params = [
            'app_id'   => $appId,
            'position' => $position,
        ];

        $response = FacebookRequests::publish($url, $params);

        if (isset($response['success']) === false)
        {
            return null;
        }

        // --------------------------------------

        return true;
    }

    /**
     * @param string $pageAccessToken
     * @param int $pageId
     * @param int $appId
     *
     * @return bool|null
     */
    public function removeTab($pageAccessToken, $pageId, $appId)
    {
        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            FacebookRequests::renderPath(FacebookConstants::PATH_PAGE_TABS, ['pageId' => $pageId]),
            ['access_token' => $pageAccessToken]
        );

        // tab params
        $params = [
            'tab' => 'app_' . $appId,
        ];

        $response = FacebookRequests::delete($url, $params);

        if (isset($response['success']) === false)
        {
            return null;
        }

        // --------------------------------------

        return true;
    }

    /**
     * @return FacebookPosts
     */
    private function getFacebookPosts()
    {
        return $this->facebookPosts;
    }
}