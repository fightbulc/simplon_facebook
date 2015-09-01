<?php

namespace Simplon\Facebook\Photo\Vo;

use Simplon\Helper\DataIoVoTrait;

/**
 * Class FacebookPhotoVo
 * @package Simplon\Facebook\Photo\Vo
 */
class FacebookPhotoVo
{
    use DataIoVoTrait;

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
    protected $caption;

    /**
     * @var bool
     */
    protected $noStory = false;

    /**
     * @param string $urlPhoto
     */
    public function __construct($urlPhoto)
    {
        $this->url = $urlPhoto;
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
     * @return FacebookPhotoVo
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
     * @return FacebookPhotoVo
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param string $caption
     *
     * @return FacebookPhotoVo
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getNoStory()
    {
        return $this->noStory;
    }

    /**
     * @param boolean $noStory
     *
     * @return FacebookPhotoVo
     */
    public function setNoStory($noStory)
    {
        $this->noStory = $noStory;

        return $this;
    }
}