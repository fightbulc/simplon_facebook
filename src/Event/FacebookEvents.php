<?php

namespace Simplon\Facebook\Event;

use Simplon\Facebook\Core\Facebook;
use Simplon\Facebook\Core\FacebookConstants;
use Simplon\Facebook\Core\FacebookRequests;
use Simplon\Facebook\Event\Vo\FacebookCreateEventVo;

/**
 * FacebookEvents
 * @package Simplon\Facebook\Event
 * @author Tino Ehrich (tino@bigpun.me)
 */
class FacebookEvents
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
     * @param $eventId
     *
     * @return bool
     * @throws \Simplon\Facebook\Core\FacebookErrorException
     */
    public function getEvent($eventId)
    {
        $params = [
            'access_token' => $this->_getAccessToken(),
        ];

        $urlReadEvent = str_replace('{{eventId}}', $eventId, FacebookConstants::PATH_EVENT_DATA);
        $response = FacebookRequests::read($urlReadEvent, $params);

        if (isset($response['data']) && !empty($response['data']))
        {
            return VoManyFactory::factory($response['data'], function ($key, $val)
            {
                return new FacebookUserAccountVo($val);
            });
        }

        return false;
    }

    /**
     * @param FacebookCreateEventVo $facebookCreateEventVo
     *
     * @return bool|string
     */
    public function createEvent(FacebookCreateEventVo $facebookCreateEventVo)
    {
        $paramsGeneric = [
            'name'        => $facebookCreateEventVo->getName(),
            'start_time'  => $facebookCreateEventVo->getTimeStart(),
            'end_time'    => $facebookCreateEventVo->getTimeEnd(),
            'description' => $facebookCreateEventVo->getDescription(),
            'location'    => $facebookCreateEventVo->getLocation(),
            'location_id' => $facebookCreateEventVo->getLocationId(),
        ];

        // ----------------------------------

        switch ($facebookCreateEventVo->getOwnerType())
        {
            case FacebookConstants::EVENT_OWNER_APP:
                $paramsCustom = [
                    'access_token' => $this->getPageAccessToken(),
                    'ticket_uri'   => $facebookCreateEventVo->getTicketUri(),
                ];

                $ownerIdentifier = $facebookCreateEventVo->getPageId();
                break;

            case FacebookConstants::EVENT_OWNER_PAGE:
                $paramsCustom = [
                    'access_token'  => $this->getPageAccessToken(),
                    'ticket_uri'    => $facebookCreateEventVo->getTicketUri(),
                    'no_feed_story' => $facebookCreateEventVo->hasNoFeedStory()
                ];

                $ownerIdentifier = $facebookCreateEventVo->getPageId();
                break;

            default:
                $paramsCustom = [
                    'access_token' => $this->getUserAccessToken(),
                    'privacy_type' => $facebookCreateEventVo->getPrivacyType()
                ];

                $ownerIdentifier = 'me';
        }

        // ----------------------------------

        $params = array_merge($paramsGeneric, $paramsCustom);

        foreach ($params as $key => $val)
        {
            if (isset($val) === false)
            {
                unset($params[$key]);
            }
        }

        // ----------------------------------

        // set correct graph url
        $urlCreateEvent = str_replace('{{ownerIdentifier}}', $ownerIdentifier, FacebookConstants::PATH_EVENT_CREATE);

        // publish
        $response = FacebookRequests::publish($urlCreateEvent, $params);

        if (isset($response['id']))
        {
            return (string)$response['id'];
        }

        return false;
    }

    /**
     * @param $facebookId
     * @param $accessToken
     *
     * @return array|bool
     */
    public function getEventAttendingIdsMany($facebookId, $accessToken)
    {
        $params = [
            'access_token' => $accessToken,
            'fields'       => 'attending.limit(99999).fields(id)',
        ];

        $data = FacebookRequests::read("/$facebookId", $params);

        if (is_array($data) && is_array($data['attending']) && is_array($data['attending']['data']))
        {
            $idsMany = [];

            foreach ($data['attending']['data'] as $item)
            {
                $idsMany[] = $item['id'];
            }

            return $idsMany;
        }

        return false;
    }

    /**
     * @param $accessToken
     * @param $facebookEventId
     *
     * @return array|mixed
     */
    public function setEventAttending($facebookEventId, $accessToken)
    {
        $params = [
            'access_token' => $accessToken
        ];

        return FacebookRequests::publish($facebookEventId . '/attending', $params);
    }

    /**
     * @param $facebookEventId
     * @param $accessToken
     *
     * @return array|mixed
     */
    public function setEventDeclined($facebookEventId, $accessToken)
    {
        $params = [
            'access_token' => $accessToken
        ];

        return FacebookRequests::publish($facebookEventId . '/declined', $params);
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
    private function getUserAccessToken()
    {
        return $this
            ->getFacebook()
            ->getUserLongTermAccessToken();
    }

    /**
     * @return string
     */
    private function getPageAccessToken()
    {
        return $this
            ->getFacebook()
            ->getPageAccessToken();
    }

    /**
     * @return string
     */
    private function getAppAccessToken()
    {
        return $this
            ->getFacebook()
            ->getAppAccessToken();
    }
}