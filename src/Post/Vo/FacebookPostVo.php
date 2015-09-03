<?php

namespace Simplon\Facebook\Post\Vo;

use Simplon\Helper\DataIoVoTrait;

/**
 * Class FacebookPostVo
 * @package Simplon\Facebook\Post\Vo
 */
class FacebookPostVo
{
    use DataIoVoTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var string
     */
    protected $picture;

    /**
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
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
     * @return FacebookPostVo
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return FacebookPostVo
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return FacebookPostVo
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     *
     * @return FacebookPostVo
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }
}