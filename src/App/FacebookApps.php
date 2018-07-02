<?php

namespace Simplon\Facebook\App;

use Simplon\Facebook\App\Data\DebugTokenData;
use Simplon\Facebook\App\Data\SignedRequestData;
use Simplon\Facebook\FacebookConstants;
use Simplon\Facebook\FacebookException;
use Simplon\Facebook\FacebookRequests;
use Simplon\Helper\CastAway;

/**
 * @package Simplon\Facebook\App
 */
class FacebookApps
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $secret;
    /**
     * @var string
     */
    private $appAccessToken;
    /**
     * @var DebugTokenData[]
     */
    private $debugTokens = [];

    /**
     * @param string $id
     * @param string $secret
     */
    public function __construct(string $id, string $secret)
    {
        $this->id = $id;
        $this->secret = $secret;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @return string
     * @throws FacebookException
     */
    public function getAppAccessToken(): string
    {
        if (empty($this->appAccessToken) === false)
        {
            return CastAway::toString($this->appAccessToken);
        }

        throw new FacebookException('Missing app access token');
    }

    /**
     * @param string $accessToken
     *
     * @return FacebookApps
     */
    public function setAppAccessToken(string $accessToken): self
    {
        $this->appAccessToken = $accessToken;

        return $this;
    }

    /**
     * @return FacebookApps
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function requestAppAccessToken(): self
    {
        $response = FacebookRequests::get(FacebookConstants::PATH_OAUTH_ACCESSTOKEN, [
            'client_id'     => $this->getId(),
            'client_secret' => $this->getSecret(),
            'grant_type'    => 'client_credentials',
        ]);

        if (empty($response['access_token']) === false)
        {
            return $this->setAppAccessToken($response['access_token']);
        }

        throw new FacebookException('Could not retrieve app access token');
    }

    /**
     * @param string $accessToken
     *
     * @return string
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function requestLongTermAccessToken(string $accessToken): string
    {
        $response = FacebookRequests::get(FacebookConstants::PATH_OAUTH_ACCESSTOKEN, [
            'client_id'         => $this->getId(),
            'client_secret'     => $this->getSecret(),
            'grant_type'        => 'fb_exchange_token',
            'fb_exchange_token' => $accessToken,
        ]);

        if (empty($response['access_token']) === false)
        {
            return $response['access_token'];
        }

        throw new FacebookException('Could not exchange tokens.');
    }

    /**
     * @param string $endpoint
     * @param array  $params
     * @param string $requestType
     *
     * @return array
     * @throws FacebookException
     */
    public function requestRawData(string $endpoint, array $params = [], string $requestType = 'get'): array
    {
        if (method_exists(FacebookRequests::class, $requestType))
        {
            return FacebookRequests::$requestType(trim($endpoint, '/'), $params);
        }

        throw new FacebookException('request type "' . $requestType . '" is not available');
    }

    /**
     * @param string $type
     * @param array  $object
     *
     * @return string
     * @throws FacebookException
     */
    public function storyObjectCreate(string $type, array $object): string
    {
        $type = strtolower($type);

        if (strpos($type, '.') === false && strpos($type, ':') === false)
        {
            throw new FacebookException('Your object type does not seem to be common nor custom');
        }

        $placeholders = ['object_type' => $type];

        $queryParams = [
            'access_token' => $this->getAppAccessToken(),
            'app_secret'   => $this->getSecret(),
        ];

        $path = FacebookRequests::buildPath(FacebookConstants::PATH_APP_STORY_OBJECT_CREATE, $placeholders, $queryParams);

        $response = FacebookRequests::post($path, [
            'object' => json_encode($object),
        ]);

        if (empty($response['id']) === false)
        {
            return (string)$response['id'];
        }

        throw new FacebookException('Could not create app story object');
    }

    /**
     * @param string $objectId
     *
     * @return array
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function storyObjectGet(string $objectId): array
    {
        $placeholders = ['id' => $objectId];

        $queryParams = [
            'access_token' => $this->getAppAccessToken(),
            'app_secret'   => $this->getSecret(),
        ];

        $path = FacebookRequests::buildPath(FacebookConstants::PATH_GRAPH_ITEM, $placeholders, $queryParams);

        $response = FacebookRequests::get($path);

        return $response;
    }

    /**
     * @param string $objectId
     *
     * @return bool
     * @throws FacebookException
     */
    public function storyObjectDelete(string $objectId): bool
    {
        $placeholders = ['id' => $objectId];

        $queryParams = [
            'access_token' => $this->getAppAccessToken(),
            'app_secret'   => $this->getSecret(),
        ];

        $path = FacebookRequests::buildPath(FacebookConstants::PATH_GRAPH_ITEM, $placeholders, $queryParams);

        $response = FacebookRequests::delete($path);

        if (empty($response['success']))
        {
            throw new FacebookException('Could not delete app story object');
        }

        return true;
    }

    /**
     * @param string $signedRequest
     *
     * @return SignedRequestData
     * @throws FacebookException
     */
    public function parseSignedRequest(string $signedRequest): SignedRequestData
    {
        $base64Decode = function ($input)
        {
            return base64_decode(strtr($input, '-_', '+/'));
        };

        list($encoded_sig, $payload) = explode('.', $signedRequest, 2);

        // decode the data
        $sig = $base64Decode($encoded_sig);
        $data = json_decode($base64Decode($payload), true);

        // confirm the signature
        $expected_sig = hash_hmac('sha256', $payload, $this->getSecret(), $raw = true);

        if ($sig !== $expected_sig)
        {
            throw new FacebookException('Failed to parse signed request. Signatures do not match.');
        }

        return (new SignedRequestData())->fromArray($data);
    }

    /**
     * @param string $accessToken
     * @param bool   $refresh
     *
     * @return DebugTokenData
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    public function getDebugTokenData(string $accessToken, bool $refresh = false): DebugTokenData
    {
        if ($refresh === true || isset($this->debugTokens[$accessToken]) === false)
        {
            $this->debugTokens[$accessToken] = $this->debugAccessToken($accessToken);
        }

        return $this->debugTokens[$accessToken];
    }

    /**
     * @param string $inputToken
     *
     * @return DebugTokenData
     * @throws FacebookException
     * @throws \Simplon\Request\RequestException
     */
    private function debugAccessToken(string $inputToken): DebugTokenData
    {
        $response = FacebookRequests::get(FacebookConstants::PATH_DEBUG_TOKEN, [
            'input_token'  => $inputToken,
            'access_token' => $this->getAppAccessToken(),
            'app_secret'   => $this->getSecret(),
        ]);

        if (empty($response['data']) === false)
        {
            return (new DebugTokenData())
                ->fromArray($response['data'])
                ->setAccessToken($inputToken)
                ;
        }

        throw new FacebookException('Cannot retrieve token information');
    }
}