<?php

namespace Simplon\Facebook\Post\Data;

use Simplon\Helper\Data\Data;

/**
 * @package Simplon\Facebook\Post\Data
 */
class PostData extends Data
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var array
     */
    protected $from;
    /**
     * @var array
     */
    protected $to;
    /**
     * @var string
     */
    protected $objectId;
    /**
     * @var string
     */
    protected $parentId;
    /**
     * @var string
     */
    protected $permalinkUrl;
    /**
     * @var string
     */
    protected $source;
    /**
     * @var string
     */
    protected $statusType;
    /**
     * @var string
     */
    protected $message;
    /**
     * @var string
     */
    protected $story;
    /**
     * @var string
     */
    protected $link;
    /**
     * @var string
     */
    protected $caption;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $picture;
    /**
     * @var string
     */
    protected $createdTime;
    /**
     * @var string
     */
    protected $updatedTime;

    /**
     * @param null|string $message
     */
    public function __construct(?string $message = null)
    {
        $this->message = $message;
    }

    /**
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return PostData
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return PostData
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return PostData
     */
    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     *
     * @return PostData
     */
    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCreatedTime(): ?string
    {
        return $this->createdTime;
    }

    /**
     * @param string $createdTime
     *
     * @return PostData
     */
    public function setCreatedTime(string $createdTime): PostData
    {
        $this->createdTime = $createdTime;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getUpdatedTime(): ?string
    {
        return $this->updatedTime;
    }

    /**
     * @param string $updatedTime
     *
     * @return PostData
     */
    public function setUpdatedTime(string $updatedTime): PostData
    {
        $this->updatedTime = $updatedTime;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getFrom(): ?array
    {
        return $this->from;
    }

    /**
     * @return null|string
     */
    public function getFromId(): ?string
    {
        return $this->getFrom() ? $this->getFrom()['id'] : null;
    }

    /**
     * @return null|string
     */
    public function getFromName(): ?string
    {
        return $this->getFrom() ? $this->getFrom()['name'] : null;
    }

    /**
     * @param array $from
     *
     * @return PostData
     */
    public function setFrom(array $from): PostData
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getTo(): ?array
    {
        return $this->to;
    }

    /**
     * @return null|string
     */
    public function getToId(): ?string
    {
        return $this->getTo() ? $this->getTo()['id'] : null;
    }

    /**
     * @return null|string
     */
    public function getToName(): ?string
    {
        return $this->getTo() ? $this->getTo()['name'] : null;
    }

    /**
     * @param array $to
     *
     * @return PostData
     */
    public function setTo(array $to): PostData
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getObjectId(): ?string
    {
        return $this->objectId;
    }

    /**
     * @param string $objectId
     *
     * @return PostData
     */
    public function setObjectId(string $objectId): PostData
    {
        $this->objectId = $objectId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    /**
     * @param string $parentId
     *
     * @return PostData
     */
    public function setParentId(string $parentId): PostData
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPermalinkUrl(): ?string
    {
        return $this->permalinkUrl;
    }

    /**
     * @param string $permalinkUrl
     *
     * @return PostData
     */
    public function setPermalinkUrl(string $permalinkUrl): PostData
    {
        $this->permalinkUrl = $permalinkUrl;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @param string $source
     *
     * @return PostData
     */
    public function setSource(string $source): PostData
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStatusType(): ?string
    {
        return $this->statusType;
    }

    /**
     * @param string $statusType
     *
     * @return PostData
     */
    public function setStatusType(string $statusType): PostData
    {
        $this->statusType = $statusType;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStory(): ?string
    {
        return $this->story;
    }

    /**
     * @param string $story
     *
     * @return PostData
     */
    public function setStory(string $story): PostData
    {
        $this->story = $story;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCaption(): ?string
    {
        return $this->caption;
    }

    /**
     * @param string $caption
     *
     * @return PostData
     */
    public function setCaption(string $caption): PostData
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return PostData
     */
    public function setDescription(string $description): PostData
    {
        $this->description = $description;

        return $this;
    }
}