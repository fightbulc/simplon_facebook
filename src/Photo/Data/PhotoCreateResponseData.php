<?php

namespace Simplon\Facebook\Photo\Data;

use Simplon\Helper\Data\Data;

/**
 * @package Simplon\Facebook\Photo\Data
 */
class PhotoCreateResponseData extends Data
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $postId;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getPostId(): ?string
    {
        return $this->postId;
    }
}