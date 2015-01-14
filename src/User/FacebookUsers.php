<?php

namespace Simplon\Facebook\User;

use Simplon\Facebook\Core\Facebook;
use Simplon\Facebook\Core\FacebookConstants;
use Simplon\Facebook\Core\FacebookErrorException;
use Simplon\Facebook\Core\FacebookRequests;
use Simplon\Facebook\User\Vo\FacebookUserAccountVo;
use Simplon\Facebook\User\Vo\FacebookUserDataVo;
use Simplon\Facebook\User\Vo\FacebookUserFriendVo;

/**
 * FacebookUsers
 * @package Simplon\Facebook\User
 * @author Tino Ehrich (tino@bigpun.me)
 */
class FacebookUsers
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
     * @param bool $retry
     *
     * @return FacebookUserDataVo
     * @throws \Simplon\Facebook\Core\FacebookErrorException
     */
    public function getUserData($retry = true)
    {
        try
        {
            $url = FacebookRequests::renderUrl(
                FacebookConstants::URL_DOMAIN_GRAPH,
                FacebookConstants::PATH_ME
            );

            $params = [
                'access_token' => $this->getAccessToken(),
            ];

            $response = FacebookRequests::read($url, $params);

            return (new FacebookUserDataVo())
                ->setData($response)
                ->setAccessToken($this->getAccessToken());

        }
        catch (FacebookErrorException $e)
        {
            // retry in case facebook wasn't quick enough to update accessToken remotely
            if ($retry !== false && $e->getCode() !== 190)
            {
                sleep(3); // lets be sure and wait 3 seconds

                return $this->getUserData(false);
            }

            throw new FacebookErrorException(
                $e->getCode(),
                $e->getSubcode(),
                $e->getMessage(),
                $e->getErrors()
            );
        }
    }

    /**
     * @return bool|Vo\FacebookUserFriendVo[]
     */
    public function getFriends()
    {
        $params = [
            'access_token' => $this->getAccessToken(),
        ];

        $response = FacebookRequests::read(FacebookConstants::PATH_ME_FRIENDS, $params);

        if (isset($response['data']))
        {
            /** @var FacebookUserFriendVo[] $voMany */
            $voMany = [];

            foreach ($response['data'] as $val)
            {
                $voMany[] = (new FacebookUserFriendVo())->setData($val);
            }

            return $voMany;
        }

        return false;
    }

    /**
     * The following user access token should have: manage_pages (extended permissions)
     * @link https://developers.facebook.com/docs/graph-api/reference/user/accounts/
     *
     * @return FacebookUserAccountVo[]|bool
     */
    public function getAccountsData()
    {
        $url = FacebookRequests::renderUrl(
            FacebookConstants::URL_DOMAIN_GRAPH,
            FacebookConstants::PATH_ME_ACCOUNTS
        );

        $params = [
            'access_token' => $this->getAccessToken(),
        ];

        $response = FacebookRequests::read($url, $params);

        if (isset($response['data']) && !empty($response['data']))
        {
            /** @var FacebookUserAccountVo[] $voMany */
            $voMany = [];

            foreach ($response['data'] as $val)
            {
                $voMany[] = (new FacebookUserAccountVo())->setData($val);
            }

            return $voMany;
        }

        return false;
    }

    /**
     * @param $actionType
     * @param $objectType
     * @param $objectValue
     *
     * @return bool|string
     * @throws \Simplon\Facebook\Core\FacebookErrorException
     */
    public function openGraphPush($actionType, $objectType, $objectValue)
    {
        $actionType = strtolower($actionType);
        $objectType = strtolower($objectType);

        if (strpos($actionType, ':') === false)
        {
            throw new FacebookErrorException(
                FacebookConstants::ERROR_USER_CODE,
                FacebookConstants::ERROR_USER_INVALID_GRAPH_ACTION_TYPE_SUBCODE,
                FacebookConstants::ERROR_USER_INVALID_GRAPH_ACTION_TYPE_MESSAGE
            );
        }

        // ----------------------------------

        $params = [
            'access_token' => $this->getAccessToken(),
            'method'       => 'POST',
            $objectType    => $objectValue,
        ];

        $pathOpenGraphCreate = str_replace('{{actionType}}', $actionType, FacebookConstants::PATH_OPEN_GRAPH_CREATE);

        $response = FacebookRequests::publish($pathOpenGraphCreate, $params);

        if (isset($response['id']))
        {
            return (string)$response['id'];
        }

        // ----------------------------------

        return false;
    }

    /**
     * @param $graphItemId
     *
     * @return array
     * @throws \Simplon\Facebook\Core\FacebookErrorException
     */
    public function openGraphRemove($graphItemId)
    {
        if (empty($graphItemId))
        {
            throw new FacebookErrorException(
                FacebookConstants::ERROR_USER_CODE,
                FacebookConstants::ERROR_USER_MISSING_GRAPH_ITEM_ID_SUBCODE,
                FacebookConstants::ERROR_USER_MISSING_GRAPH_ITEM_ID_MESSAGE
            );
        }

        // ----------------------------------

        $params = [
            'access_token' => $this->getAccessToken(),
            'method'       => 'DELETE',
        ];

        $pathOpenGraphItem = str_replace('{{itemId}}', $graphItemId, FacebookConstants::PATH_OPEN_GRAPH_DATA);

        return FacebookRequests::publish($pathOpenGraphItem, $params);
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