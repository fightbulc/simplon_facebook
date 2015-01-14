<?php

namespace Simplon\Facebook\User\Vo;

use Simplon\Helper\DataSetter;

/**
 * FacebookUserAccountVo
 * @package Simplon\Facebook\User\Vo
 * @author Tino Ehrich (tino@bigpun.me)
 */
class FacebookUserAccountVo
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var array
     */
    private $perms;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $category;

    /**
     * @var array
     */
    private $categoryList;

    /**
     * @param array $data
     *
     * @return FacebookUserAccountVo
     */
    public function setData(array $data)
    {
        (new DataSetter())
            ->assignField('id', function ($val) { $this->setId($val); })
            ->assignField('perms', function ($val) { $this->setPerms($val); })
            ->assignField('access_token', function ($val) { $this->setAccessToken($val); })
            ->assignField('name', function ($val) { $this->setName($val); })
            ->assignField('category', function ($val) { $this->setCategory($val); })
            ->assignField('category_list', function ($val) { $this->setCategoryList($val); })
            ->applyOn($data);

        return $this;
    }

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
            $voMany[] = (new FacebookUserAcountCategoryListVo())->setData($val);
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
}