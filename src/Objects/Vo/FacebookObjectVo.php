<?php

namespace Simplon\Facebook\Objects\Vo;

use Simplon\Helper\CastAway;
use Simplon\Helper\DataSetter;

/**
 * @package Simplon\Facebook\Objects\Vo
 */
class FacebookObjectVo
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $title;
    /**
     * @var array
     */
    private $image;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $updatedTime;
    /**
     * @var array
     */
    private $application;

    /**
     * @param array $data
     *
     * @return FacebookObjectVo
     */
    public function setData(array $data)
    {
        (new DataSetter())
            ->assignField('id', function ($val) { $this->setId($val); })
            ->assignField('url', function ($val) { $this->setUrl($val); })
            ->assignField('type', function ($val) { $this->setType($val); })
            ->assignField('title', function ($val) { $this->setTitle($val); })
            ->assignField('image', function ($val) { $this->setImage($val); })
            ->assignField('description', function ($val) { $this->setDescription($val); })
            ->assignField('updated_time', function ($val) { $this->setUpdatedTime($val); })
            ->assignField('application', function ($val) { $this->setApplication($val); })
            ->applyOn($data)
        ;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return static
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return static
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return static
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return static
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return array
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return string|null
     */
    public function getImageUrl()
    {
        return !empty($this->image['url']) ? $this->image['url'] : null;
    }

    /**
     * @return int|null
     */
    public function getImageWidth()
    {
        return !empty($this->image['width']) ? CastAway::toInt($this->image['width']) : null;
    }

    /**
     * @return int|null
     */
    public function getImageHeight()
    {
        return !empty($this->image['height']) ? CastAway::toInt($this->image['height']) : null;
    }

    /**
     * @param array $image
     *
     * @return static
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return static
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedTime()
    {
        return $this->updatedTime;
    }

    /**
     * @param string $updatedTime
     *
     * @return static
     */
    public function setUpdatedTime($updatedTime)
    {
        $this->updatedTime = $updatedTime;

        return $this;
    }

    /**
     * @return array
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @return string|null
     */
    public function getApplicationId()
    {
        return !empty($this->application['id']) ? $this->application['id'] : null;
    }

    /**
     * @return string|null
     */
    public function getApplicationName()
    {
        return !empty($this->application['name']) ? $this->application['name'] : null;
    }

    /**
     * @return string|null
     */
    public function getApplicationUrl()
    {
        return !empty($this->application['url']) ? $this->application['url'] : null;
    }

    /**
     * @param array $application
     *
     * @return static
     */
    public function setApplication($application)
    {
        $this->application = $application;

        return $this;
    }
}