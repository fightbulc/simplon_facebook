<?php

namespace Simplon\Facebook\User\Vo;

use Simplon\Helper\DataIoVoTrait;

/**
 * FacebookUserAcountCategoryListVo
 * @package Simplon\Facebook\User\Vo
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class FacebookUserAcountCategoryListVo
{
    use DataIoVoTrait;

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
     * @return FacebookUserAcountCategoryListVo
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
     * @return FacebookUserAcountCategoryListVo
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
}