<?php

namespace Simplon\Facebook\User\Vo;

use Simplon\Helper\DataIoVoTrait;

/**
 * FacebookUserAccountVo
 * @package Simplon\Facebook\User\Vo
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class FacebookUserAccountVo
{
    use DataIoVoTrait;

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
     * @return FacebookUserAccountVo
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return (string)$this->accessToken;
    }

    /**
     * @param string $category
     *
     * @return FacebookUserAccountVo
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return (string)$this->category;
    }

    /**
     * @param array $categoryList
     *
     * @return FacebookUserAccountVo
     */
    public function setCategoryList($categoryList)
    {
        $this->categoryList = $categoryList;

        return $this;
    }

    /**
     * @return array
     */
    public function getCategoryList()
    {
        return (array)$this->categoryList;
    }

    /**
     * @return bool
     */
    public function hasCategoryList()
    {
        $categoryList = $this->getCategoryList();

        return empty($categoryList) === false;
    }

    /**
     * @return FacebookUserAcountCategoryListVo[]|bool
     */
    public function getFacebookUserAcountCategoryListVoMany()
    {
        $categoryList = $this->getCategoryList();

        if (empty($categoryList))
        {
            return false;
        }

        // --------------------------------------

        /** @var FacebookUserAcountCategoryListVo[] $voMany */
        $voMany = [];

        foreach ($categoryList as $val)
        {
            $voMany[] = (new FacebookUserAcountCategoryListVo())->fromArray($val);
        }

        return $voMany;
    }

    /**
     * @param string $id
     *
     * @return FacebookUserAccountVo
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return (string)$this->id;
    }

    /**
     * @param string $name
     *
     * @return FacebookUserAccountVo
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (string)$this->name;
    }

    /**
     * @param array $perms
     *
     * @return FacebookUserAccountVo
     */
    public function setPerms($perms)
    {
        $this->perms = $perms;

        return $this;
    }

    /**
     * @return array
     */
    public function getPerms()
    {
        return (array)$this->perms;
    }

    /**
     * @param array $hasPerms
     *
     * @return bool
     */
    public function hasPerms(array $hasPerms)
    {
        $result = array_intersect($this->getPerms(), $hasPerms);

        return count($result) === count($hasPerms);
    }
}