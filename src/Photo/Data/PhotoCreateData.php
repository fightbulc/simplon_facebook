<?php

namespace Simplon\Facebook\Photo\Data;

use Simplon\Helper\Data\Data;

/**
 * @package Simplon\Facebook\Photo\Data
 */
class PhotoCreateData extends Data
{
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
    protected $noStory;

    /**
     * @param string $url
     * @param null|string $caption
     * @param bool $noStory
     */
    public function __construct(string $url, ?string $caption = null, bool $noStory = false)
    {
        $this->url = $url;
        $this->caption = $caption;
        $this->noStory = $noStory;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * @return bool
     */
    public function isNoStory(): bool
    {
        return $this->noStory;
    }
}