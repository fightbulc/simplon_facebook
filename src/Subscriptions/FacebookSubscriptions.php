<?php

namespace Simplon\Facebook\Subscriptions;

use Simplon\Facebook\App\FacebookApps;
use Simplon\Facebook\FacebookConstants;
use Simplon\Facebook\FacebookException;
use Simplon\Facebook\FacebookRequests;
use Simplon\Facebook\Subscriptions\Vo\FacebookSubscriptionMessageVo;
use Simplon\Facebook\Subscriptions\Vo\FacebookSubscriptionVo;
use Simplon\Helper\DataIterator;
use Simplon\Helper\Helper;
use Simplon\Request\Request;

/**
 * Class FacebookSubscriptions
 * @package Simplon\Facebook\Subscriptions
 */
class FacebookSubscriptions
{
    const OBJECT_USER = 'user';
    const OBJECT_PAGE = 'page';
    const OBJECT_PERMISSIONS = 'permissions';
    const OBJECT_PAYMENTS = 'payments';

    /**
     * @var FacebookApps
     */
    private $facebookApps;

    /**
     * @param FacebookApps $facebookApps
     */
    public function __construct(FacebookApps $facebookApps)
    {
        $this->facebookApps = $facebookApps;
    }

    /**
     * Possible fields values:
     * @see https://developers.facebook.com/docs/graph-api/real-time-updates/v2.4#subscribefields
     *
     * @param string $object
     * @param array $fields
     * @param string $callbackUrl
     * @param string $callbackVerifyToken
     *
     * @return bool
     * @throws FacebookException
     */
    public function create($object, array $fields, $callbackUrl, $callbackVerifyToken)
    {
        if ($this->isValidObject($object) === false)
        {
            throw new FacebookException('Applied object is not supported');
        }

        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_APP_SUBSCRIPTIONS],
            ['appId' => $this->getFacebookApps()->getId()],
            ['access_token' => $this->getFacebookApps()->getAccessToken()]
        );

        $params = [
            'object'       => strtolower($object),
            'callback_url' => $callbackUrl,
            'fields'       => join(',', $fields),
            'verify_token' => $callbackVerifyToken,
        ];

        $response = FacebookRequests::post($url, $params);

        if (empty($response['success']) === false)
        {
            return true;
        }

        throw new FacebookException('Could not create app subscription');
    }

    /**
     * @return Vo\FacebookSubscriptionVo[]
     * @throws FacebookException
     */
    public function get()
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_APP_SUBSCRIPTIONS],
            ['appId' => $this->getFacebookApps()->getId()],
            ['access_token' => $this->getFacebookApps()->getAccessToken()]
        );

        $response = FacebookRequests::get($url);

        if (empty($response['data']) === false)
        {
            /** @var FacebookSubscriptionVo[] $data */
            $data = DataIterator::iterate($response['data'], function ($data)
            {
                return (new FacebookSubscriptionVo())->fromArray($data);
            });

            return $data;
        }

        throw new FacebookException('Could not create app subscription');
    }

    /**
     * @param string $object
     *
     * @return bool
     * @throws FacebookException
     */
    public function delete($object)
    {
        if ($this->isValidObject($object) === false)
        {
            throw new FacebookException('Applied object is not supported');
        }

        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_APP_SUBSCRIPTIONS],
            ['appId' => $this->getFacebookApps()->getId()],
            ['access_token' => $this->getFacebookApps()->getAccessToken()]
        );

        $params = [
            'object' => strtolower($object),
        ];

        $response = FacebookRequests::delete($url, $params);

        if (empty($response['success']) === false)
        {
            return true;
        }

        throw new FacebookException('Could not delete app subscription');
    }

    /**
     * @return string
     */
    public function buildVerifyToken()
    {
        return Helper::createRandomToken();
    }

    /**
     * Print return value as an response to Facebook's incoming GET request
     * @see https://developers.facebook.com/docs/graph-api/real-time-updates/v2.4#setup
     *
     * @param array $requestGetParams
     * @param string $callbackVerifyToken
     *
     * @return string
     * @throws FacebookException
     */
    public function handleVerificationRequest(array $requestGetParams, $callbackVerifyToken)
    {
        $hasRequiredParams =
            in_array('hub_mode', $requestGetParams)
            && in_array('hub_challenge', $requestGetParams)
            && in_array('hub_verify_token', $requestGetParams);

        if ($hasRequiredParams === false)
        {
            throw new FacebookException('Missing at least one required GET parameter');
        }

        // verify-token must match the prior defined one @see: self::create
        if ($requestGetParams['hub_verify_token'] === $callbackVerifyToken)
        {
            throw new FacebookException('Verify token does not match');
        }

        return (string)$requestGetParams['hub_challenge'];
    }

    /**
     * @return null|FacebookSubscriptionMessageVo
     */
    public function handleSubscriptionMessageRequest()
    {
        if (Request::isPost())
        {
            $message = Request::getInputStream();

            $facebookSubscriptionMessageVo = new FacebookSubscriptionMessageVo();
            $facebookSubscriptionMessageVo->fromArray($message);

            return $facebookSubscriptionMessageVo;
        }

        return null;
    }

    /**
     * @param string $object
     *
     * @return bool
     */
    private function isValidObject($object)
    {
        return in_array(
            strtolower($object),
            [
                self::OBJECT_PAGE,
                self::OBJECT_USER,
                self::OBJECT_PERMISSIONS,
                self::OBJECT_PAYMENTS
            ]
        );
    }

    /**
     * @return FacebookApps
     */
    private function getFacebookApps()
    {
        return $this->facebookApps;
    }
}