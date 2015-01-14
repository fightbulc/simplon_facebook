<?php

namespace Simplon\Facebook\User\Vo;

use Simplon\Helper\DataSetter;

/**
 * FacebookUserFriendVo
 * @package Simplon\Facebook\User\Vo
 * @author Tino Ehrich (tino@bigpun.me)
 */
class FacebookUserFriendVo
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
     * @param array $data
     *
     * @return FacebookUserFriendVo
     */
    public function setData(array $data)
    {
        (new DataSetter())
            ->assignField('id', function ($val) { $this->setId($val); })
            ->assignField('name', function ($val) { $this->setName($val); })
            ->applyOn($data);

        return $this;
    }

    /**
     * @param string $id
     *
     * @return FacebookUserFriendVo
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
     * @return FacebookUserFriendVo
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