<?php

namespace Simplon\Facebook\User;

use Simplon\Facebook\App\FacebookApps;
use Simplon\Facebook\FacebookConstants;
use Simplon\Facebook\FacebookException;
use Simplon\Facebook\FacebookRequests;
use Simplon\Facebook\Photo\FacebookPhotos;
use Simplon\Facebook\Photo\Vo\FacebookPhotoVo;
use Simplon\Facebook\Post\FacebookPosts;
use Simplon\Facebook\Post\Vo\FacebookPostVo;
use Simplon\Facebook\User\Vo\FacebookUserAccountVo;
use Simplon\Facebook\User\Vo\FacebookUserDataVo;
use Simplon\Facebook\User\Vo\FacebookUserFriendVo;
use Simplon\Helper\CastAway;
use Simplon\Helper\DataIterator;
use Simplon\Helper\Helper;

/**
 * FacebookUsers
 * @package Simplon\Facebook\User
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class FacebookUsers
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
     * @var FacebookPhotos
     */
    private $facebookPhotos;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var string
     */
    private $userId;

    /**
     * @param FacebookApps $facebookApps
     * @param FacebookPosts $facebookPosts
     * @param FacebookPhotos $facebookPhotos
     */
    public function __construct(FacebookApps $facebookApps, FacebookPosts $facebookPosts, FacebookPhotos $facebookPhotos)
    {
        $this->facebookApps = $facebookApps;
        $this->facebookPosts = $facebookPosts;
        $this->facebookPhotos = $facebookPhotos;
    }

    /**
     * @return string
     * @throws FacebookException
     */
    public function getAccessToken()
    {
        if ($this->accessToken !== null)
        {
            return CastAway::toString($this->accessToken);
        }

        throw new FacebookException('Missing user access token');
    }

    /**
     * @param string $accessToken
     *
     * @return FacebookUsers
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        // read user id from token
        $this->userId = $this
            ->getFacebookApps()
            ->getDebugTokenVo($accessToken)
            ->getUserId();

        return $this;
    }

    /**
     * @return string
     * @throws FacebookException
     */
    public function getUserId()
    {
        if (empty($this->userId) === false)
        {
            return CastAway::toString($this->userId);
        }

        throw new FacebookException('Missing user id');
    }

    /**
     * List of possible values for the scope:
     * @see https://developers.facebook.com/docs/facebook-login/permissions#reference
     *
     * @param string $uriRedirect
     * @param array $scope
     * @param string $responseType
     *
     * @return string
     */
    public function getUrlAuthentication($uriRedirect, array $scope = [], $responseType = 'code')
    {
        $params = [
            'client_id'     => $this->getFacebookApps()->getId(),
            'redirect_uri'  => Helper::urlTrim($uriRedirect) . '/',
            'response_type' => $responseType,
            'scope'         => $scope,
            'auth_type'     => 'rerequest', // re-request revoked permissions
        ];

        return Helper::urlRender(
            [FacebookConstants::URL_FACEBOOK, FacebookConstants::PATH_OAUTH],
            [],
            $params
        );
    }

    /**
     * @param string $code
     * @param string $uriRedirect
     *
     * @return FacebookUsers
     * @throws FacebookException
     */
    public function requestAccessTokenByCode($code, $uriRedirect)
    {
        // remove possible hash-tag value
        $code = preg_replace('/#.*?$/', '', $code);

        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_OAUTH_ACCESSTOKEN]
        );

        $params = [
            'client_id'     => $this->getFacebookApps()->getId(),
            'client_secret' => $this->getFacebookApps()->getSecret(),
            'redirect_uri'  => Helper::urlTrim($uriRedirect) . '/',
            'code'          => $code,
        ];

        $response = FacebookRequests::get($url, $params);

        if (empty($response['access_token']) === false)
        {
            return $this->setAccessToken($response['access_token']);
        }

        throw new FacebookException('Could not retrieve access token by code.');
    }

    /**
     * @return array
     * @throws FacebookException
     */
    public function getPermissions()
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_ME_PERMISSIONS]
        );

        $params = [
            'access_token' => $this->getAccessToken(),
        ];

        $response = FacebookRequests::get($url, $params);

        if (empty($response['data']) === false)
        {
            return (array)$response['data'];
        }

        throw new FacebookException('Could not retrieve user permissions');
    }

    /**
     * @return bool
     */
    public function isShortTermAccessToken()
    {
        return $this
            ->getFacebookApps()
            ->getDebugTokenVo($this->getAccessToken(), true)
            ->isShortTermToken();
    }

    /**
     * @return FacebookUsers
     */
    public function getLongTermAccessToken()
    {
        if ($this->isShortTermAccessToken() === true)
        {
            $this->requestLongTermAccessToken();
        }

        return $this;
    }

    /**
     * @return FacebookUsers
     * @throws FacebookException
     */
    public function requestLongTermAccessToken()
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_OAUTH_ACCESSTOKEN]
        );

        $params = [
            'client_id'         => $this->getFacebookApps()->getId(),
            'client_secret'     => $this->getFacebookApps()->getSecret(),
            'grant_type'        => 'fb_exchange_token',
            'fb_exchange_token' => $this->getAccessToken(),
        ];

        $response = FacebookRequests::get($url, $params);

        if (empty($response['access_token']) === false)
        {
            return $this->setAccessToken($response['access_token']);
        }

        throw new FacebookException('Could not exchange tokens.');
    }

    /**
     * @return FacebookUserDataVo
     * @throws FacebookException
     */
    public function getUserData()
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_ME]
        );

        $params = [
            'access_token' => $this->getAccessToken(),
            'fields'       => 'id,name,first_name,middle_name,last_name,email,age_range,locale,location,timezone,gender,link',
        ];

        $response = FacebookRequests::get($url, $params);

        return (new FacebookUserDataVo())
            ->setData($response)
            ->setAccessToken($this->getAccessToken());
    }

    /**
     * @return Vo\FacebookUserFriendVo[]
     * @throws FacebookException
     */
    public function getFriends()
    {
        $params = [
            'access_token' => $this->getAccessToken(),
        ];

        $response = FacebookRequests::get(FacebookConstants::PATH_ME_FRIENDS, $params);

        if (empty($response['data']) === false)
        {
            /** @var FacebookUserFriendVo[] $voMany */
            $voMany = DataIterator::iterate($response['data'], function ($data)
            {
                return (new FacebookUserFriendVo())->setData($data);
            });

            return $voMany;
        }

        throw new FacebookException('Could not fetch friends');
    }

    /**
     * The following user access token should have: manage_pages (extended permissions)
     * @link https://developers.facebook.com/docs/graph-api/reference/user/accounts/
     *
     * @return FacebookUserAccountVo[]|bool
     */
    public function getAccountsData()
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_ME_ACCOUNTS]
        );

        $params = [
            'access_token' => $this->getAccessToken(),
        ];

        $response = FacebookRequests::get($url, $params);

        if (empty($response['data']) === false)
        {
            /** @var FacebookUserAccountVo[] $voMany */
            $voMany = DataIterator::iterate($response['data'], function ($data)
            {
                return (new FacebookUserAccountVo())->fromArray($data);
            });

            return $voMany;
        }

        return false;
    }

    /**
     * @param string $actionType
     * @param string $objectType
     * @param string $objectValue
     *
     * @return string
     * @throws FacebookException
     */
    public function storyCreate($actionType, $objectType, $objectValue)
    {
        $actionType = strtolower($actionType);
        $objectType = strtolower($objectType);

        if (strpos($actionType, '.') === false && strpos($actionType, ':') === false)
        {
            throw new FacebookException('Your action type does not seem to be common nor custom');
        }

        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_ME_STORY_CREATE],
            ['actionType' => $actionType],
            ['access_token' => $this->getAccessToken()]
        );

        $params = [
            $objectType => $objectValue,
        ];

        $response = FacebookRequests::post($url, $params);

        if (empty($response['id']) === false)
        {
            return (string)$response['id'];
        }

        throw new FacebookException('Could not create user story');
    }

    /**
     * @param string $storyId
     *
     * @return bool
     * @throws FacebookException
     */
    public function storyDelete($storyId)
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_GRAPH_ITEM],
            ['id' => $storyId],
            ['access_token' => $this->getAccessToken()]
        );

        $response = FacebookRequests::delete($url);

        if (empty($response['success']) === false)
        {
            return true;
        }

        throw new FacebookException('Could not delete user story');
    }

    /**
     * @param FacebookPostVo $facebookPostVo
     *
     * @return string
     * @throws FacebookException
     */
    public function feedCreate(FacebookPostVo $facebookPostVo)
    {
        return $this
            ->getFacebookPosts()
            ->create(
                $this->getAccessToken(),
                $this->getUserId(),
                $facebookPostVo
            );
    }

    /**
     * @param FacebookPostVo $facebookPostVo
     *
     * @return bool
     * @throws FacebookException
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
     * @return bool
     * @throws FacebookException
     */
    public function feedDelete($postId)
    {
        return $this
            ->getFacebookPosts()
            ->delete($this->getAccessToken(), $postId);
    }

    /**
     * @param FacebookPhotoVo $facebookPhotoVo
     *
     * @return null|string
     * @throws FacebookException
     */
    public function photoCreate(FacebookPhotoVo $facebookPhotoVo)
    {
        return $this
            ->getFacebookPhotos()
            ->create(
                $this->getAccessToken(),
                $this->getUserId(),
                $facebookPhotoVo
            );
    }

    /**
     * @param string $photoId
     *
     * @return bool
     * @throws FacebookException
     */
    public function photoDelete($photoId)
    {
        return $this
            ->getFacebookPhotos()
            ->delete($this->getAccessToken(), $photoId);
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

    /**
     * @return FacebookPhotos
     */
    private function getFacebookPhotos()
    {
        return $this->facebookPhotos;
    }
}