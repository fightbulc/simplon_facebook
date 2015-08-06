<?php

namespace Simplon\Facebook\Page;

use Simplon\Facebook\Core\FacebookConstants;
use Simplon\Facebook\Core\FacebookRequests;
use Simplon\Facebook\Page\Vo\FacebookPageVo;
use Simplon\Facebook\Post\FacebookPosts;

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
        $params = [
            'access_token' => $pageAccessToken,
        ];

        $response = FacebookRequests::read(
            str_replace('{{pageId}}', $urlname, FacebookConstants::PATH_PAGE_DATA),
            $params
        );

        return (new FacebookPageVo())->setData($response);
    }

    /**
     * @param string      $pageAccessToken
     * @param string      $pageId
     * @param string      $message
     * @param null|string $link
     *
     * @return null|string
     */
    public function feedPublish($pageAccessToken, $pageId, $message, $link = null)
    {
        $path = FacebookRequests::renderPath(
            FacebookConstants::PATH_PAGE_FEED,
            ['pageId' => $pageId]
        );

        return $this
            ->getFacebookPosts()
            ->feedPublish($path, $pageAccessToken, $message, $link);
    }

    /**
     * @param string      $pageAccessToken
     * @param string      $postId
     * @param string      $message
     * @param null|string $link
     *
     * @return bool
     */
    public function feedUpdate($pageAccessToken, $postId, $message, $link = null)
    {
        return $this
            ->getFacebookPosts()
            ->feedUpdate($pageAccessToken, $postId, $message, $link);
    }

    /**
     * @param string $pageAccessToken
     * @param string $postId
     *
     * @return bool|null
     */
    public function feedRemove($pageAccessToken, $postId)
    {
        return $this
            ->getFacebookPosts()
            ->feedRemove($pageAccessToken, $postId);
    }

    /**
     * @param string   $pageAccessToken
     * @param int      $pageId
     * @param int      $appId
     * @param null|int $position
     *
     * @return bool|null
     */
    public function addTab($pageAccessToken, $pageId, $appId, $position = null)
    {
        $path = FacebookRequests::renderPath(
            FacebookConstants::PATH_PAGE_TABS,
            ['pageId' => $pageId]
        );

        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            $path,
            ['access_token' => $pageAccessToken]
        );

        // tab params
        $params = [
            'app_id'   => $appId,
            'position' => $position

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
     * @param int    $pageId
     * @param int    $appId
     *
     * @return bool|null
     */
    public function removeTab($pageAccessToken, $pageId, $appId)
    {
        $path = FacebookRequests::renderPath(
            FacebookConstants::PATH_PAGE_TABS,
            ['pageId' => $pageId]
        );

        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            $path,
            ['access_token' => $pageAccessToken]
        );

        // tab params
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