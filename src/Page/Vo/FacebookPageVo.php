<?php

namespace Simplon\Facebook\Page\Vo;

use Simplon\Helper\DataSetter;

/**
 * FacebookPageVo
 * @package Simplon\Facebook\Page\Vo
 * @author Tino Ehrich (tino@bigpun.me)
 */
class FacebookPageVo
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var array
     */
    private $cover;

    /**
     * @var int
     */
    private $likes;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $promotionEligible;

    /**
     * @var bool
     */
    private $offerEligible;

    /**
     * @var int
     */
    private $newLikeCount;

    /**
     * @var bool
     */
    private $isPublished;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $category;

    /**
     * @var bool
     */
    private $canPost;

    /**
     * @var string
     */
    private $about;

    /**
     * @var int
     */
    private $talkingAboutCount;

    /**
     * @var int
     */
    private $unreadMessageCount;

    /**
     * @var int
     */
    private $unreadNotificationCount;

    /**
     * @var int
     */
    private $unseenMessageCount;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $website;

    /**
     * @var int
     */
    private $wereHereCount;

    /**
     * @param array $data
     *
     * @return FacebookPageVo
     */
    public function setData(array $data)
    {
        (new DataSetter())
            ->assignField('id', function ($val) { $this->setId($val); })
            ->assignField('cover', function ($val) { $this->setCover($val); })
            ->assignField('likes', function ($val) { $this->setLikes($val); })
            ->assignField('link', function ($val) { $this->setLink($val); })
            ->assignField('name', function ($val) { $this->setName($val); })
            ->assignField('promotion_eligible', function ($val) { $this->setPromotionEligible($val); })
            ->assignField('offer_eligible', function ($val) { $this->setOfferEligible($val); })
            ->assignField('new_like_count', function ($val) { $this->setNewLikeCount($val); })
            ->assignField('is_published', function ($val) { $this->setIsPublished($val); })
            ->assignField('description', function ($val) { $this->setDescription($val); })
            ->assignField('category', function ($val) { $this->setCategory($val); })
            ->assignField('can_post', function ($val) { $this->setCanPost($val); })
            ->assignField('about', function ($val) { $this->setAbout($val); })
            ->assignField('talking_about_count', function ($val) { $this->setTalkingAboutCount($val); })
            ->assignField('unread_message_count', function ($val) { $this->setUnreadMessageCount($val); })
            ->assignField('unread_notif_count', function ($val) { $this->setUnreadNotificationCount($val); })
            ->assignField('unseen_message_count', function ($val) { $this->setUnseenMessageCount($val); })
            ->assignField('username', function ($val) { $this->setUsername($val); })
            ->assignField('website', function ($val) { $this->setWebsite($val); })
            ->assignField('were_here_count', function ($val) { $this->setWereHereCount($val); })
            ->applyOn($data);

        return $this;
    }

    /**
     * @param string $about
     *
     * @return FacebookPageVo
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * @return string
     */
    public function getAbout()
    {
        return (string)$this->about;
    }

    /**
     * @param bool $canPost
     *
     * @return FacebookPageVo
     */
    public function setCanPost($canPost)
    {
        $this->canPost = $canPost;

        return $this;
    }

    /**
     * @return bool
     */
    public function getCanPost()
    {
        return (bool)$this->canPost;
    }

    /**
     * @param string $category
     *
     * @return FacebookPageVo
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return (string)$this->category;
    }

    /**
     * @param array $cover
     *
     * @return FacebookPageVo
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * @return array
     */
    public function getCover()
    {
        return (array)$this->cover;
    }

    /**
     * @param string $description
     *
     * @return FacebookPageVo
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
     * @return FacebookPageVo
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
     * @param bool $isPublished
     *
     * @return FacebookPageVo
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsPublished()
    {
        return (bool)$this->isPublished;
    }

    /**
     * @param int $likes
     *
     * @return FacebookPageVo
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * @return int
     */
    public function getLikes()
    {
        return (int)$this->likes;
    }

    /**
     * @param string $link
     *
     * @return FacebookPageVo
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return (string)$this->link;
    }

    /**
     * @param string $name
     *
     * @return FacebookPageVo
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
     * @param int $newLikeCount
     *
     * @return FacebookPageVo
     */
    public function setNewLikeCount($newLikeCount)
    {
        $this->newLikeCount = $newLikeCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getNewLikeCount()
    {
        return (int)$this->newLikeCount;
    }

    /**
     * @param bool $offerEligible
     *
     * @return FacebookPageVo
     */
    public function setOfferEligible($offerEligible)
    {
        $this->offerEligible = $offerEligible;

        return $this;
    }

    /**
     * @return bool
     */
    public function getOfferEligible()
    {
        return (bool)$this->offerEligible;
    }

    /**
     * @param bool $promotionEligible
     *
     * @return FacebookPageVo
     */
    public function setPromotionEligible($promotionEligible)
    {
        $this->promotionEligible = $promotionEligible;

        return $this;
    }

    /**
     * @return bool
     */
    public function getPromotionEligible()
    {
        return (bool)$this->promotionEligible;
    }

    /**
     * @param int $talkingAboutCount
     *
     * @return FacebookPageVo
     */
    public function setTalkingAboutCount($talkingAboutCount)
    {
        $this->talkingAboutCount = $talkingAboutCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getTalkingAboutCount()
    {
        return (int)$this->talkingAboutCount;
    }

    /**
     * @param int $unreadMessageCount
     *
     * @return FacebookPageVo
     */
    public function setUnreadMessageCount($unreadMessageCount)
    {
        $this->unreadMessageCount = $unreadMessageCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getUnreadMessageCount()
    {
        return (int)$this->unreadMessageCount;
    }

    /**
     * @param int $unreadNotificationCount
     *
     * @return FacebookPageVo
     */
    public function setUnreadNotificationCount($unreadNotificationCount)
    {
        $this->unreadNotificationCount = $unreadNotificationCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getUnreadNotificationCount()
    {
        return (int)$this->unreadNotificationCount;
    }

    /**
     * @param int $unseenMessageCount
     *
     * @return FacebookPageVo
     */
    public function setUnseenMessageCount($unseenMessageCount)
    {
        $this->unseenMessageCount = $unseenMessageCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getUnseenMessageCount()
    {
        return (int)$this->unseenMessageCount;
    }

    /**
     * @param string $username
     *
     * @return FacebookPageVo
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return (string)$this->username;
    }

    /**
     * @param string $website
     *
     * @return FacebookPageVo
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return (string)$this->website;
    }

    /**
     * @param int $wereHereCount
     *
     * @return FacebookPageVo
     */
    public function setWereHereCount($wereHereCount)
    {
        $this->wereHereCount = $wereHereCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getWereHereCount()
    {
        return (int)$this->wereHereCount;
    }
}