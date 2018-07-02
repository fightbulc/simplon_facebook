<?php

namespace Simplon\Facebook\Photo\Data;

use DusanKasan\Knapsack\Collection;
use Simplon\Helper\Data\Data;

/**
 * @package Simplon\Facebook\Photo\Data
 */
class PhotoData extends Data
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $pageStoryId;
    /**
     * @var string
     */
    protected $link;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $caption;
    /**
     * @var array
     */
    protected $from;
    /**
     * @var array
     */
    protected $images;
    /**
     * @var string
     */
    protected $picture;
    /**
     * @var int
     */
    protected $width;
    /**
     * @var int
     */
    protected $height;
    /**
     * @var string
     */
    protected $createdTime;
    /**
     * @var string
     */
    protected $updatedTime;

    /**
     * @param null|string $link
     */
    public function __construct(?string $link = null)
    {
        parent::__construct();
        $this->link = $link;
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
    public function getPageStoryId(): ?string
    {
        return $this->pageStoryId;
    }

    /**
     * @return string
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @return null|string
     */
    public function getCaption(): ?string
    {
        return $this->caption;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
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
     * @return PhotoImageData[]|null
     */
    public function getImages(): ?array
    {
        if ($this->images)
        {
            $map = function ($image) {
                return (new PhotoImageData())->fromArray($image);
            };

            return Collection::from($this->images)->map($map)->toArray();
        }

        return null;
    }

    /**
     * @return null|string
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @return null|string
     */
    public function getCreatedTime(): ?string
    {
        return $this->createdTime;
    }

    /**
     * @return null|string
     */
    public function getUpdatedTime(): ?string
    {
        return $this->updatedTime;
    }
}