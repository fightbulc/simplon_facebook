<?php

namespace Simplon\Facebook\Page;

use Simplon\Facebook\Core\Facebook;
use Simplon\Facebook\Core\FacebookConstants;
use Simplon\Facebook\Core\FacebookRequests;
use Simplon\Facebook\Page\Vo\FacebookPageVo;

/**
 * FacebookPages
 * @package Simplon\Facebook\Page
 * @author Tino Ehrich (tino@bigpun.me)
 */
class FacebookPages
{
    /**
     * @var Facebook
     */
    private $facebook;

    /**
     * @param Facebook $facebook
     */
    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;
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

        $urlPageData = str_replace('{{pageIdentifier}}', $urlname, FacebookConstants::PATH_PAGE_DATA);

        $response = FacebookRequests::read($urlPageData, $params);

        return (new FacebookPageVo())->setData($response);
    }

    /**
     * @return Facebook
     */
    private function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @return string
     */
    private function getAccessToken()
    {
        return $this
            ->getFacebook()
            ->getUserLongTermAccessToken();
    }
}