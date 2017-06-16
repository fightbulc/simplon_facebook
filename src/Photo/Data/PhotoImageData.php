<?php

namespace Simplon\Facebook\Photo\Data;

use Simplon\Helper\Data\Data;

/**
 * @package Simplon\Facebook\Photo\Data
 */
class PhotoImageData extends Data
{
    /**
     * @var string
     */
    protected $source;
    /**
     * @var int
     */
    protected $width;
    /**
     * @var int
     */
    protected $height;

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }
}