<?php

namespace Simplon\Facebook\User;

use DusanKasan\Knapsack\Collection;
use Simplon\Facebook\App\FacebookApps;
use Simplon\Facebook\FacebookConstants;
use Simplon\Facebook\FacebookException;
use Simplon\Facebook\FacebookRequests;
use Simplon\Facebook\Photo\Data\PhotoCreateData;
use Simplon\Facebook\Photo\Data\PhotoCreateResponseData;
use Simplon\Facebook\Photo\Data\PhotoData;
use Simplon\Facebook\Photo\FacebookPhotos;
use Simplon\Facebook\Post\Data\PostData;
use Simplon\Facebook\Post\FacebookPosts;
use Simplon\Facebook\User\Data\UserAccountData;
use Simplon\Facebook\User\Data\UserData;
use Simplon\Facebook\User\Data\UserFriendData;
use Simplon\Helper\CastAway;
use Simplon\Helper\Data\InstanceData;
use Simplon\Helper\Instances;

/**
 * @package Simplon\Facebook\User
 */
class FacebookUsers
{
    /**
     * @var FacebookApps
     */
    private $facebookApps;
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
     */
    public function __construct(FacebookApps $facebookApps)
    {
        $this->facebookApps = $facebookApps;
    }

    /**
     * @return null|string
     */
    public function getAccessToken(): ?string
    {
        if ($this->accessToken !== null)
        {
            return CastAway::toString($this->accessToken);
        }

        return null;
    }

    /**
     * @param string $accessToken
     *
     * @return FacebookUsers
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;
        $this->userId = $this->getFacebookApps()->getDebugTokenData($accessToken)->getUserId();

        return $this;
    }

    /**
     * @return null|string
     */
    public function getUserId(): ?string
    {
        if (empty($this->userId) === false)
        {
            return CastAway::toString($this->userId);
        }

        return null;
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
    public function getUrlAuthentication(string $uriRedirect, array $scope = [], string $responseType = 'code'): string
    {
        return FacebookRequests::buildFacebookUrl(
            FacebookRequests::buildPath(FacebookConstants::PATH_OAUTH, [], [
                'client_id'     => $this->getFacebookApps()->getId(),
                'redirect_uri'  => trim($uriRedirect, '/'),
                'response_type' => $responseType,
                'scope'         => $scope,
                'auth_type'     => 'rerequest', // re-request revoked permissions
            ])
        );
    }

    /**
     * @param string $code
     * @param string $oauthUriRedirect
     *
     * @return FacebookUsers
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function requestAccessTokenByCode(string $code, string $oauthUriRedirect): self
    {
        // remove possible hash-tag value
        $code = preg_replace('/#.*?$/', '', $code);

        $response = FacebookRequests::get(FacebookConstants::PATH_OAUTH_ACCESSTOKEN, [
            'client_id'     => $this->getFacebookApps()->getId(),
            'client_secret' => $this->getFacebookApps()->getSecret(),
            'redirect_uri'  => trim($oauthUriRedirect, '/'),
            'code'          => $code,
        ]);

        if (empty($response['access_token']) === false)
        {
            return $this->setAccessToken($response['access_token']);
        }

        throw new FacebookException('Could not retrieve access token by code.');
    }

    /**
     * @return array
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function getPermissions(): array
    {
        $response = FacebookRequests::get(FacebookConstants::PATH_ME_PERMISSIONS, [
            'access_token' => $this->getAccessToken(),
        ]);

        if (empty($response['data']) === false)
        {
            return CastAway::toArray($response['data']);
        }

        throw new FacebookException('Could not retrieve user permissions');
    }

    /**
     * @return bool
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function isShortTermAccessToken(): bool
    {
        return $this->getFacebookApps()->getDebugTokenData($this->getAccessToken(), true)->isShortTermToken();
    }

    /**
     * @return FacebookUsers
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function getLongTermAccessToken(): self
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
     * @throws \Simplon\Request\RequestException
     */
    public function requestLongTermAccessToken(): self
    {
        $response = FacebookRequests::get(FacebookConstants::PATH_OAUTH_ACCESSTOKEN, [
            'client_id'         => $this->getFacebookApps()->getId(),
            'client_secret'     => $this->getFacebookApps()->getSecret(),
            'grant_type'        => 'fb_exchange_token',
            'fb_exchange_token' => $this->getAccessToken(),
        ]);

        if (empty($response['access_token']) === false)
        {
            return $this->setAccessToken($response['access_token']);
        }

        throw new FacebookException('Could not exchange tokens.');
    }

    /**
     * @return UserData
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function getUserData(): UserData
    {
        $response = FacebookRequests::get(FacebookConstants::PATH_ME, [
            'access_token' => $this->getAccessToken(),
            'fields'       => 'id,name,first_name,middle_name,last_name,email,age_range,locale,location,timezone,gender,link',
        ]);

        return (new UserData())->fromArray($response)->setAccessToken($this->getAccessToken());
    }

    /**
     * @return UserFriendData[]
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function getFriends(): array
    {
        $response = FacebookRequests::get(FacebookConstants::PATH_ME_FRIENDS, [
            'access_token' => $this->getAccessToken(),
        ]);

        if (empty($response['data']) === false)
        {
            $map = function ($data) {
                return (new UserFriendData())->fromArray($data);
            };

            return Collection::from($response['data'])->map($map)->toArray();
        }

        return [];
    }

    /**
     * The following user access token should have: manage_pages (extended permissions)
     * @link https://developers.facebook.com/docs/graph-api/reference/user/accounts/
     *
     * @return UserAccountData[]|null
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function getAccountsData(): ?array
    {
        $params = [
            'access_token' => $this->getAccessToken(),
        ];

        $response = FacebookRequests::get(FacebookConstants::PATH_ME_ACCOUNTS, $params);

        if (empty($response['data']) === false)
        {
            $map = function ($data) {
                return (new UserAccountData())->fromArray($data);
            };

            return Collection::from($response['data'])->map($map)->toArray();
        }

        return null;
    }

    /**
     * @param string $actionType
     * @param string $objectType
     * @param string $objectValue
     *
     * @return string
     * @throws FacebookException
     */
    public function storyCreate(string $actionType, string $objectType, string $objectValue): string
    {
        $actionType = strtolower($actionType);
        $objectType = strtolower($objectType);

        if (strpos($actionType, '.') === false && strpos($actionType, ':') === false)
        {
            throw new FacebookException('Your action type does not seem to be common nor custom');
        }

        $placeholders = ['action_type' => $actionType];
        $queryParams = ['access_token' => $this->getAccessToken()];
        $path = FacebookRequests::buildPath(FacebookConstants::PATH_ME_STORY_CREATE, $placeholders, $queryParams);

        $response = FacebookRequests::post($path, [
            $objectType => $objectValue,
        ]);

        if (empty($response['id']) === false)
        {
            return CastAway::toString($response['id']);
        }

        throw new FacebookException('Could not create user story');
    }

    /**
     * @param string $storyId
     *
     * @return bool
     * @throws FacebookException
     */
    public function storyDelete(string $storyId): bool
    {
        $placeholders = ['id' => $storyId];
        $queryParams = ['access_token' => $this->getAccessToken()];
        $path = FacebookRequests::buildPath(FacebookConstants::PATH_GRAPH_ITEM, $placeholders, $queryParams);

        $response = FacebookRequests::delete($path);

        if (empty($response['success']) === false)
        {
            return true;
        }

        throw new FacebookException('Could not delete user story');
    }

    /**
     * @param PostData $postData
     *
     * @return string
     * @throws FacebookException
     */
    public function feedCreate(PostData $postData): string
    {
        return $this->getFacebookPosts()->create($this->getAccessToken(), $this->getUserId(), $postData);
    }

    /**
     * @param string $id
     * @param array|null $fields
     *
     * @return PostData|PhotoData
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function feedRead(string $id, ?array $fields = null)
    {
        return $this->getFacebookPosts()->read($this->getAccessToken(), $id, $fields);
    }

    /**
     * @param PostData $postData
     *
     * @return bool
     * @throws FacebookException
     */
    public function feedUpdate(PostData $postData): bool
    {
        return $this->getFacebookPosts()->update($this->getAccessToken(), $postData);
    }

    /**
     * @param string $postId
     *
     * @return bool
     * @throws FacebookException
     */
    public function feedDelete(string $postId): bool
    {
        return $this->getFacebookPosts()->delete($this->getAccessToken(), $postId);
    }

    /**
     * @param PhotoCreateData $photoCreateData
     *
     * @return PhotoCreateResponseData
     * @throws FacebookException
     */
    public function photoCreate(PhotoCreateData $photoCreateData): PhotoCreateResponseData
    {
        return $this->getFacebookPhotos()->create($this->getAccessToken(), $this->getUserId(), $photoCreateData);
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
     * @return FacebookApps
     */
    private function getFacebookApps(): FacebookApps
    {
        return $this->facebookApps;
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