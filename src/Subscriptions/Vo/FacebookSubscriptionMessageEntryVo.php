<?php

namespace Simplon\Facebook\Subscriptions\Vo;

use Simplon\Helper\DataIoVoTrait;

/**
 * Class FacebookSubscriptionMessageEntryVo
 * @package Simplon\Facebook\Subscriptions\Vo
 */
class FacebookSubscriptionMessageEntryVo
{
    use DataIoVoTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $changedFields;

    /**
     * @var int
     */
    protected $time;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getChangedFields()
    {
        return $this->changedFields;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }
}