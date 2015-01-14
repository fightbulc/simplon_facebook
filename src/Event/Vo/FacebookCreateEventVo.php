<?php

namespace Simplon\Facebook\Event\Vo;

/**
 * FacebookCreateEventVo
 * @package Simplon\Facebook\Event\Vo
 * @author Tino Ehrich (tino@bigpun.me)
 */
class FacebookCreateEventVo extends FacebookEventVo
{
    /**
     * @var string
     */
    protected $pageId;

    /**
     * @var string
     */
    protected $locationId;

    /**
     * @var bool
     */
    protected $noFeedStory;

    /**
     * @param string $pageId
     *
     * @return FacebookCreateEventVo
     */
    public function setPageId($pageId)
    {
        // set page as owner
        $this->setOwnerTypePage();

        $this->pageId = $pageId;

        return $this;
    }

    /**
     * @return string
     */
    public function getPageId()
    {
        return (string)$this->pageId;
    }

    /**
     * @param string $pageId
     *
     * @return FacebookCreateEventVo
     */
    public function setAppId($pageId)
    {
        // set app as owner
        $this->setOwnerTypeApp();

        $this->pageId = $pageId;

        return $this;
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return (string)$this->pageId;
    }

    /**
     * @param string $locationId
     *
     * @return FacebookCreateEventVo
     */
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocationId()
    {
        return (string)$this->locationId;
    }

    /**
     * @param bool $noFeedStory
     *
     * @return FacebookCreateEventVo
     */
    public function setNoFeedStory($noFeedStory)
    {
        $this->noFeedStory = $noFeedStory;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasNoFeedStory()
    {
        return $this->noFeedStory !== false;
    }
}