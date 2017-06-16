<?php

namespace Simplon\Facebook\Page\Data;

use Simplon\Helper\CastAway;
use Simplon\Helper\Data\Data;

/**
 * @package Simplon\Facebook\Page\Data
 */
class PageData extends Data
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var array
     */
    protected $cover;
    /**
     * @var int
     */
    protected $likes;
    /**
     * @var string
     */
    protected $link;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var bool
     */
    protected $promotionEligible;
    /**
     * @var bool
     */
    protected $offerEligible;
    /**
     * @var int
     */
    protected $newLikeCount;
    /**
     * @var bool
     */
    protected $isPublished;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $category;
    /**
     * @var bool
     */
    protected $canPost;
    /**
     * @var string
     */
    protected $about;
    /**
     * @var int
     */
    protected $talkingAboutCount;
    /**
     * @var int
     */
    protected $unreadMessageCount;
    /**
     * @var int
     */
    protected $unreadNotificationCount;
    /**
     * @var int
     */
    protected $unseenMessageCount;
    /**
     * @var string
     */
    protected $username;
    /**
     * @var string
     */
    protected $website;
    /**
     * @var int
     */
    protected $wereHereCount;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getCover(): array
    {
        return CastAway::toArray($this->cover);
    }

    /**
     * @return int
     */
    public function getLikes(): int
    {
        return CastAway::toInt($this->likes);
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isPromotionEligible(): bool
    {
        return $this->promotionEligible;
    }

    /**
     * @return bool
     */
    public function isOfferEligible(): bool
    {
        return $this->offerEligible;
    }

    /**
     * @return int
     */
    public function getNewLikeCount(): int
    {
        return CastAway::toInt($this->newLikeCount);
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return bool
     */
    public function isCanPost(): bool
    {
        return $this->canPost;
    }

    /**
     * @return string
     */
    public function getAbout(): string
    {
        return $this->about;
    }

    /**
     * @return int
     */
    public function getTalkingAboutCount(): int
    {
        return CastAway::toInt($this->talkingAboutCount);
    }

    /**
     * @return int
     */
    public function getUnreadMessageCount(): int
    {
        return CastAway::toInt($this->unreadMessageCount);
    }

    /**
     * @return int
     */
    public function getUnreadNotificationCount(): int
    {
        return CastAway::toInt($this->unreadNotificationCount);
    }

    /**
     * @return int
     */
    public function getUnseenMessageCount(): int
    {
        return CastAway::toInt($this->unseenMessageCount);
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getWebsite(): string
    {
        return $this->website;
    }

    /**
     * @return int
     */
    public function getWereHereCount(): int
    {
        return CastAway::toInt($this->wereHereCount);
    }
}