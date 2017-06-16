<?php

namespace Simplon\Facebook\User\Data;

use Simplon\Helper\CastAway;
use Simplon\Helper\Data\Data;

/**
 * @package Simplon\Facebook\User\Data
 */
class UserAccountData extends Data
{
    const PERM_ADMINISTER = 'ADMINISTER';

    /**
     * @var string
     */
    protected $id;
    /**
     * @var array
     */
    protected $perms;
    /**
     * @var string
     */
    protected $accessToken;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $category;
    /**
     * @var array
     */
    protected $categoryList;

    /**
     * @param string $accessToken
     *
     * @return UserAccountData
     */
    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return CastAway::toString($this->accessToken);
    }

    /**
     * @param string $category
     *
     * @return UserAccountData
     */
    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return CastAway::toString($this->category);
    }

    /**
     * @param array $categoryList
     *
     * @return UserAccountData
     */
    public function setCategoryList(array $categoryList): self
    {
        $this->categoryList = $categoryList;

        return $this;
    }

    /**
     * @return array
     */
    public function getCategoryList(): array
    {
        return CastAway::toArray($this->categoryList);
    }

    /**
     * @return bool
     */
    public function hasCategoryList(): bool
    {
        $categoryList = $this->getCategoryList();

        return empty($categoryList) === false;
    }

    /**
     * @return UserAcountCategoryListData[]|null
     */
    public function getFacebookUserAcountCategoryListVoMany(): ?array
    {
        $categoryList = $this->getCategoryList();

        if (!empty($categoryList))
        {
            /** @var UserAcountCategoryListData[] $data */
            $data = [];

            foreach ($categoryList as $val)
            {
                $data[] = (new UserAcountCategoryListData())->fromArray($val);
            }

            return $data;
        }

        return null;
    }

    /**
     * @param string $id
     *
     * @return UserAccountData
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
     * @return UserAccountData
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

    /**
     * @param array $perms
     *
     * @return UserAccountData
     */
    public function setPerms(array $perms): self
    {
        $this->perms = $perms;

        return $this;
    }

    /**
     * @return array
     */
    public function getPerms(): array
    {
        return CastAway::toArray($this->perms);
    }

    /**
     * @param array $hasPerms
     *
     * @return bool
     */
    public function hasPerms(array $hasPerms): bool
    {
        $result = array_intersect($this->getPerms(), $hasPerms);

        return count($result) === count($hasPerms);
    }
}