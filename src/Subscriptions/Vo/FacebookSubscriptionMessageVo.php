<?php

namespace Simplon\Facebook\Subscriptions\Vo;

use Simplon\Helper\DataIoVoTrait;
use Simplon\Helper\DataIterator;

/**
 * Class FacebookSubscriptionMessageVo
 * @package Simplon\Facebook\Subscriptions\Vo
 */
class FacebookSubscriptionMessageVo
{
    use DataIoVoTrait;

    /**
     * @var string
     */
    protected $object;

    /**
     * @var FacebookSubscriptionMessageEntryVo[]
     */
    protected $entry;

    /**
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return FacebookSubscriptionMessageEntryVo[]
     */
    public function getEntry()
    {
        return DataIterator::iterate($this->entry, function ($data)
        {
            return (new FacebookSubscriptionMessageEntryVo())->fromArray($data);
        });
    }
}