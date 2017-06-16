<?php

namespace Simplon\Facebook\User\Data;

use Simplon\Helper\CastAway;
use Simplon\Helper\Data\Data;

/**
 * @package Simplon\Facebook\User\Data
 */
class UserAcountCategoryListData extends Data
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $id
     *
     * @return UserAcountCategoryListData
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
     * @return UserAcountCategoryListData
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