<?php

namespace Simplon\Facebook\App;

use Simplon\Facebook\FacebookConstants;
use Simplon\Facebook\FacebookException;
use Simplon\Facebook\FacebookRequests;
use Simplon\Facebook\App\Vo\DebugTokenVo;
use Simplon\Facebook\App\Vo\SignedRequestVo;
use Simplon\Helper\CastAway;
use Simplon\Helper\Helper;

/**
 * Class FacebookApps
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
    private $accessToken;

    /**
     * @var DebugTokenVo[]
     */
    private $debugTokens = [];

    /**
     * @param string $id
     * @param string $secret
     */
    public function __construct($id, $secret)
    {
        $this->id = $id;
        $this->secret = $secret;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @return string
     * @throws FacebookException
     */
    public function getAccessToken()
    {
        if (empty($this->accessToken) === false)
        {
            return CastAway::toString($this->accessToken);
        }

        throw new FacebookException('Missing app access token');
    }

    /**
     * @param string $accessToken
     *
     * @return FacebookApps
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return FacebookApps
     * @throws FacebookException
     */
    public function requestAccessToken()
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_OAUTH_ACCESSTOKEN]
        );

        $params = [
            'client_id'     => $this->getId(),
            'client_secret' => $this->getSecret(),
            'grant_type'    => 'client_credentials',
        ];

        $response = FacebookRequests::get($url, $params);

        if (empty($response['access_token']) === false)
        {
            return $this->setAccessToken($response['access_token']);
        }

        throw new FacebookException('Could not retrieve app access token');
    }

    /**
     * @param string $type
     * @param array $object
     *
     * @return string
     * @throws FacebookException
     */
    public function storyObjectCreate($type, array $object)
    {
        $type = strtolower($type);

        if (strpos($type, '.') === false && strpos($type, ':') === false)
        {
            throw new FacebookException('Your object type does not seem to be common nor custom');
        }

        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_APP_STORY_OBJECT_CREATE],
            ['objectType' => $type],
            ['access_token' => $this->getAccessToken()]
        );

        $params = [
            'object' => json_encode($object),
        ];

        $response = FacebookRequests::post($url, $params);

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
     */
    public function storyObjectGet($objectId)
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_GRAPH_ITEM],
            ['id' => $objectId],
            ['access_token' => $this->getAccessToken()]
        );

        $response = FacebookRequests::get($url);

        return CastAway::toArray(json_decode($response, true));
    }

    /**
     * @param string $objectId
     *
     * @return array
     * @throws FacebookException
     */
    public function storyObjectDelete($objectId)
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_GRAPH_ITEM],
            ['id' => $objectId],
            ['access_token' => $this->getAccessToken()]
        );

        $response = FacebookRequests::delete($url);

        if (empty($response['success']) === false)
        {
            return true;
        }

        throw new FacebookException('Could not delete app story object');
    }

    /**
     * @param string $signedRequest
     *
     * @return SignedRequestVo
     * @throws FacebookException
     */
    public function parseSignedRequest($signedRequest)
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

        return new SignedRequestVo($data);
    }

    /**
     * @param string $accessToken
     * @param bool $refresh
     *
     * @return DebugTokenVo
     */
    public function getDebugTokenVo($accessToken, $refresh = false)
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
     * @return DebugTokenVo
     * @throws FacebookException
     */
    private function debugAccessToken($inputToken)
    {
        $url = Helper::urlRender(
            [
                FacebookConstants::URL_GRAPH,
                FacebookConstants::PATH_DEBUG_TOKEN
            ]
        );

        $params = [
            'input_token'  => $inputToken,
            'access_token' => $this->getAccessToken(),
        ];

        $response = FacebookRequests::get($url, $params);

        if (empty($response['data']) === false)
        {
            return (new DebugTokenVo())
                ->setData($response['data'])
                ->setAccessToken($inputToken);
        }

        throw new FacebookException('Cannot retrieve token information');
    }
}