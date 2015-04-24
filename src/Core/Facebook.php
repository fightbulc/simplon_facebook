<?php

namespace Simplon\Facebook\Core;

use Simplon\Facebook\Core\Vo\FacebookAuthVo;
use Simplon\Facebook\Core\Vo\FacebookDebugTokenVo;

/**
 * Facebook
 * @package Simplon\Facebook\Core
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class Facebook
{
    /**
     * @var FacebookAuthVo
     */
    protected $facebookAuthVo;

    /**
     * @var string
     */
    protected $userAccessToken;

    /**
     * @var string
     */
    protected $appAccessToken;

    /**
     * @var string
     */
    protected $pageAccessToken;

    /**
     * @var FacebookDebugTokenVo[]
     */
    protected $debugTokenVoMany = [];

    /**
     * @param FacebookAuthVo $facebookAuthVo
     */
    public function __construct(FacebookAuthVo $facebookAuthVo)
    {
        $this->setFacebookAuthVo($facebookAuthVo);
    }

    /**
     * @return FacebookAuthVo
     */
    public function getFacebookAuthVo()
    {
        return $this->facebookAuthVo;
    }

    /**
     * @param string $uriRedirect
     * @param array  $scope
     * @param string $responseType
     *
     * @return string
     */
    public function getUrlLogin($uriRedirect, array $scope = [], $responseType = 'code')
    {
        $params = [
            'client_id'     => $this->getFacebookAuthVo()->getAppId(),
            'redirect_uri'  => $uriRedirect,
            'response_type' => $responseType,
            'scope'         => $scope,
            'auth_type'     => 'rerequest',
        ];

        return FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_FACEBOOK,
            FacebookConstants::PATH_LOGIN,
            $params
        );
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this
            ->getFacebookAuthVo()
            ->getAppId();
    }

    /**
     * @return string
     */
    public function getAppSecret()
    {
        return $this
            ->getFacebookAuthVo()
            ->getAppSecret();
    }

    /**
     * @param      $accessToken
     * @param bool $refresh
     *
     * @return FacebookDebugTokenVo
     */
    public function getFacebookDebugTokenVo($accessToken, $refresh = false)
    {
        if ($refresh === true || isset($this->debugTokenVoMany[$accessToken]) === false)
        {
            $this->debugTokenVoMany[$accessToken] = $this->debugAccessToken($accessToken);
        }

        return $this->debugTokenVoMany[$accessToken];
    }

    /**
     * @param mixed $appAccessToken
     *
     * @return Facebook
     */
    public function setAppAccessToken($appAccessToken)
    {
        $this->appAccessToken = $appAccessToken;

        return $this;
    }

    /**
     * @return string
     * @throws FacebookErrorException
     */
    public function getAppAccessToken()
    {
        $accessToken = (string)$this->appAccessToken;

        if (empty($accessToken) === true)
        {
            $this->requestAppAccessToken();

            $accessToken = (string)$this->appAccessToken;

            if (empty($accessToken) === true)
            {
                throw new FacebookErrorException(
                    FacebookConstants::ERROR_MISSING_DATA_CODE,
                    FacebookConstants::ERROR_MISSING_ACCESSTOKEN_APP_SUBCODE,
                    FacebookConstants::ERROR_MISSING_ACCESSTOKEN_APP_MESSAGE
                );
            }
        }

        return $accessToken;
    }

    /**
     * @param string $pageAccessToken
     *
     * @return Facebook
     */
    public function setPageAccessToken($pageAccessToken)
    {
        $this->pageAccessToken = $pageAccessToken;

        return $this;
    }

    /**
     * @return string
     * @throws FacebookErrorException
     */
    public function getPageAccessToken()
    {
        $accessToken = (string)$this->pageAccessToken;

        if (empty($accessToken) === true)
        {
            throw new FacebookErrorException(
                FacebookConstants::ERROR_MISSING_DATA_CODE,
                FacebookConstants::ERROR_MISSING_ACCESSTOKEN_PAGE_SUBCODE,
                FacebookConstants::ERROR_MISSING_ACCESSTOKEN_PAGE_MESSAGE
            );
        }

        return $accessToken;
    }

    /**
     * @return bool|string
     * @throws FacebookErrorException
     */
    public function requestPageAccessToken()
    {
        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            FacebookConstants::PATH_OAUTH_ACCESSTOKEN
        );

        $params = [
            'client_id'     => $this->getAppId(),
            'client_secret' => $this->getAppSecret(),
            'grant_type'    => 'client_credentials',
        ];

        $response = FacebookRequests::read($url, $params);

        if (isset($response['access_token']) === true)
        {
            $this->setAppAccessToken($response['access_token']);

            return $this->getAppAccessToken();
        }

        return false;
    }

    /**
     * @param string $userAccessToken
     *
     * @return Facebook
     */
    public function setUserAccessToken($userAccessToken)
    {
        $this->userAccessToken = $userAccessToken;

        return $this;
    }

    /**
     * @return string
     * @throws FacebookErrorException
     */
    public function getUserAccessToken()
    {
        $accessToken = (string)$this->userAccessToken;

        if (empty($accessToken) === true)
        {
            throw new FacebookErrorException(
                FacebookConstants::ERROR_MISSING_DATA_CODE,
                FacebookConstants::ERROR_MISSING_ACCESSTOKEN_USER_SUBCODE,
                FacebookConstants::ERROR_MISSING_ACCESSTOKEN_USER_MESSAGE
            );
        }

        return $accessToken;
    }

    /**
     * @return bool
     */
    public function isUserShortTermAccessToken()
    {
        return $this
            ->getFacebookDebugTokenVo($this->getUserAccessToken(), true)
            ->isShortTermToken();
    }

    /**
     * @return string
     * @throws FacebookErrorException
     */
    public function getUserLongTermAccessToken()
    {
        if ($this->isUserShortTermAccessToken() === true)
        {
            $this->requestLongTermUserAccessToken();
        }

        return $this->getUserAccessToken();
    }

    /**
     * @return bool|Facebook
     */
    public function requestLongTermUserAccessToken()
    {
        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            FacebookConstants::PATH_OAUTH_ACCESSTOKEN
        );

        $params = [
            'client_id'         => $this->getAppId(),
            'client_secret'     => $this->getAppSecret(),
            'grant_type'        => 'fb_exchange_token',
            'fb_exchange_token' => $this->getUserAccessToken(),
        ];

        $response = FacebookRequests::read($url, $params);

        if (isset($response['access_token']) === true)
        {
            return $this->setUserAccessToken($response['access_token']);
        }

        return false;
    }

    /**
     * @param $code
     * @param $redirectUri
     *
     * @return bool|string
     * @throws FacebookErrorException
     */
    public function requestUserAccessTokenByCode($code, $redirectUri)
    {
        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            FacebookConstants::PATH_OAUTH_ACCESSTOKEN
        );

        $params = [
            'client_id'     => $this->getAppId(),
            'client_secret' => $this->getAppSecret(),
            'redirect_uri'  => $redirectUri,
            'code'          => $code,
        ];

        $response = FacebookRequests::read($url, $params);

        if (isset($response['access_token']) === true)
        {
            $this->setUserAccessToken($response['access_token']);

            return $this->getUserAccessToken();
        }

        return false;
    }

    /**
     * @return bool|string
     * @throws FacebookErrorException
     */
    public function requestAppAccessToken()
    {
        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            FacebookConstants::PATH_OAUTH_ACCESSTOKEN
        );

        $params = [
            'client_id'     => $this->getAppId(),
            'client_secret' => $this->getAppSecret(),
            'grant_type'    => 'client_credentials',
        ];

        $response = FacebookRequests::read($url, $params);

        if (isset($response['access_token']) === true)
        {
            $this->setAppAccessToken($response['access_token']);

            return $this->getAppAccessToken();
        }

        return false;
    }

    /**
     * @param $inputToken
     *
     * @return bool|FacebookDebugTokenVo
     */
    public function debugAccessToken($inputToken)
    {
        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            FacebookConstants::PATH_DEBUG_TOKEN
        );

        $params = [
            'input_token'  => $inputToken,
            'access_token' => $this->getAppAccessToken(),
        ];

        $response = FacebookRequests::read($url, $params);

        if (isset($response['data']) === true)
        {
            return (new FacebookDebugTokenVo())->setData($response['data']);
        }

        return false;
    }

    /**
     * @param FacebookAuthVo $facebookAuthVo
     *
     * @return Facebook
     */
    protected function setFacebookAuthVo($facebookAuthVo)
    {
        $this->facebookAuthVo = $facebookAuthVo;

        return $this;
    }
}