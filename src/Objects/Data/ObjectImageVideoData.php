<?php

namespace Simplon\Facebook\Objects\Data;

use Simplon\Helper\Data\Data;

/**
 * @package Simplon\Facebook\Objects\Data
 */
class ObjectImageVideoData extends Data
{
    /**
     * @var int
     */
    protected $height;
    /**
     * @var int
     */
    protected $width;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $url;
    /**
     * @var string
     */
    protected $secureUrl;

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return null|string
     */
    public function getSecureUrl(): ?string
    {
        return $this->secureUrl;
    }
}