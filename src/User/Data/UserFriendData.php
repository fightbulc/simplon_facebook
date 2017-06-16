<?php

namespace Simplon\Facebook\User\Data;

use Simplon\Helper\CastAway;
use Simplon\Helper\Data\Data;

/**
 * @package Simplon\Facebook\User\Data
 */
class UserFriendData extends Data
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $id
     *
     * @return UserFriendData
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return CastAway::toString($this->id);
    }

    /**
     * @param string $name
     *
     * @return UserFriendData
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return CastAway::toString($this->name);
    }
}