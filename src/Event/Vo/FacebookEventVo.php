<?php

namespace Simplon\Facebook\Event\Vo;

use Simplon\Facebook\Core\FacebookConstants;
use Simplon\Helper\DataSetter;

/**
 * FacebookEventVo
 * @package Simplon\Facebook\Event\Vo
 * @author Tino Ehrich (tino@bigpun.me)
 */
class FacebookEventVo
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $timeStart;

    /**
     * @var string
     */
    private $timeEnd;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $ticketUri;

    /**
     * @var string
     */
    private $owner;

    /**
     * @var string
     */
    private $ownerType = FacebookConstants::EVENT_OWNER_USER;

    /**
     * @var string
     */
    private $picture;

    /**
     * @var string
     */
    private $privacyType;

    /**
     * @var string
     */
    private $venue;

    /**
     * @var string
     */
    private $updatedAt;

    /**
     * @param array $data
     *
     * @return FacebookEventVo
     */
    public function setData(array $data)
    {
        (new DataSetter())
            ->assignField('id', function ($val) { $this->setId($val); })
            ->assignField('owner', function ($val) { $this->setOwner($val); })
            ->assignField('name', function ($val) { $this->setName($val); })
            ->assignField('description', function ($val) { $this->setDescription($val); })
            ->assignField('start_time', function ($val) { $this->setTimeStart($val); })
            ->assignField('end_time', function ($val) { $this->setTimeEnd($val); })
            ->assignField('location', function ($val) { $this->setLocation($val); })
            ->assignField('venue', function ($val) { $this->setVenue($val); })
            ->assignField('picture', function ($val) { $this->setPicture($val); })
            ->assignField('privacy', function ($val) { $this->setPrivacyType($val); })
            ->assignField('ticket_uri', function ($val) { $this->setTicketUri($val); })
            ->assignField('updated_time', function ($val) { $this->setUpdatedAt($val); })
            ->applyOn($data);

        return $this;
    }

    /**
     * @param string $description
     *
     * @return FacebookEventVo
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return (string)$this->description;
    }

    /**
     * @param string $id
     *
     * @return FacebookEventVo
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return (string)$this->id;
    }

    /**
     * @param string $location
     *
     * @return FacebookEventVo
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return (string)$this->location;
    }

    /**
     * @param string $name
     *
     * @return FacebookEventVo
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (string)$this->name;
    }

    /**
     * @param string $owner
     *
     * @return FacebookEventVo
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return string
     */
    public function getOwner()
    {
        return (string)$this->owner;
    }

    /**
     * @return FacebookEventVo
     */
    public function setOwnerTypeUser()
    {
        return $this->setOwnerType(FacebookConstants::EVENT_OWNER_USER);
    }

    /**
     * @return FacebookEventVo
     */
    public function setOwnerTypePage()
    {
        return $this->setOwnerType(FacebookConstants::EVENT_OWNER_PAGE);
    }

    /**
     * @return FacebookEventVo
     */
    public function setOwnerTypeApp()
    {
        return $this->setOwnerType(FacebookConstants::EVENT_OWNER_APP);
    }

    /**
     * @return string
     */
    public function getOwnerType()
    {
        return strtoupper($this->ownerType);
    }

    /**
     * @param string $picture
     *
     * @return FacebookEventVo
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return string
     */
    public function getPicture()
    {
        return (string)$this->picture;
    }

    /**
     * @return FacebookEventVo
     */
    public function setPrivacyTypeOpen()
    {
        return $this->setPrivacyType(FacebookConstants::EVENT_PRIVACY_TYPE_OPEN);
    }

    /**
     * @return FacebookEventVo
     */
    public function setPrivacyTypeSecret()
    {
        return $this->setPrivacyType(FacebookConstants::EVENT_PRIVACY_TYPE_SECRET);
    }

    /**
     * @return FacebookEventVo
     */
    public function setPrivacyTypeFriends()
    {
        return $this->setPrivacyType(FacebookConstants::EVENT_PRIVACY_TYPE_FRIENDS);
    }

    /**
     * @return FacebookEventVo
     */
    public function setPrivacyTypeClosed()
    {
        return $this->setPrivacyType(FacebookConstants::EVENT_PRIVACY_TYPE_CLOSED);
    }

    /**
     * @return string
     */
    public function getPrivacyType()
    {
        return strtoupper($this->privacyType);
    }

    /**
     * @param string $timeEnd
     *
     * @return FacebookEventVo
     */
    public function setTimeEnd($timeEnd)
    {
        $this->timeEnd = $timeEnd;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimeEnd()
    {
        return (string)$this->timeEnd;
    }

    /**
     * @param string $timeStart
     *
     * @return FacebookEventVo
     */
    public function setTimeStart($timeStart)
    {
        $this->timeStart = $timeStart;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimeStart()
    {
        return (string)$this->timeStart;
    }

    /**
     * @param string $updatedAt
     *
     * @return FacebookEventVo
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return (string)$this->updatedAt;
    }

    /**
     * @param string $uriTicket
     *
     * @return FacebookEventVo
     */
    public function setTicketUri($uriTicket)
    {
        $this->ticketUri = $uriTicket;

        return $this;
    }

    /**
     * @return string
     */
    public function getTicketUri()
    {
        return (string)$this->ticketUri;
    }

    /**
     * @param string $venue
     *
     * @return FacebookEventVo
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;

        return $this;
    }

    /**
     * @return string
     */
    public function getVenue()
    {
        return (string)$this->venue;
    }

    /**
     * @param string $ownerType
     *
     * @return FacebookEventVo
     */
    private function setOwnerType($ownerType)
    {
        $this->ownerType = $ownerType;

        return $this;
    }

    /**
     * @param string $privacy
     *
     * @return FacebookEventVo
     */
    private function setPrivacyType($privacy)
    {
        $this->privacyType = $privacy;

        return $this;
    }
}