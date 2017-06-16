<?php

namespace Simplon\Facebook\Objects\Data;

use DusanKasan\Knapsack\Collection;
use Simplon\Helper\CastAway;
use Simplon\Helper\Data\Data;

/**
 * @package Simplon\Facebook\Objects\Data
 */
class ObjectData extends Data
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $url;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var array
     */
    protected $image;
    /**
     * @var array
     */
    protected $video;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $updatedTime;
    /**
     * @var array
     */
    protected $application;
    /**
     * @var bool
     */
    protected $isScraped;

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
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return ObjectImageVideoData[]|null
     */
    public function getImage(): ?array
    {
        if ($this->image)
        {
            $map = function ($image) {
                return (new ObjectImageVideoData())->fromArray($image);
            };

            return Collection::from($this->image)->map($map)->toArray();
        }

        return null;
    }

    /**
     * @return ObjectImageVideoData[]|null
     */
    public function getVideo(): ?array
    {
        if ($this->video)
        {
            $map = function ($video) {
                return (new ObjectImageVideoData())->fromArray($video);
            };

            return Collection::from($this->video)->map($map)->toArray();
        }

        return null;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getUpdatedTime(): ?string
    {
        return $this->updatedTime;
    }

    /**
     * @return array|null
     */
    public function getApplication(): ?array
    {
        return CastAway::toArray($this->application);
    }

    /**
     * @return null|string
     */
    public function getApplicationId(): ?string
    {
        return !empty($this->application['id']) ? $this->application['id'] : null;
    }

    /**
     * @return null|string
     */
    public function getApplicationName(): ?string
    {
        return !empty($this->application['name']) ? $this->application['name'] : null;
    }

    /**
     * @return null|string
     */
    public function getApplicationUrl(): ?string
    {
        return !empty($this->application['url']) ? $this->application['url'] : null;
    }

    /**
     * @return bool|null
     */
    public function isScraped(): ?bool
    {
        return $this->isScraped;
    }
}