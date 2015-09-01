<?php

namespace Simplon\Facebook\Subscriptions\Vo;

use Simplon\Helper\DataIoVoTrait;

class FacebookSubscriptionVo
{
    use DataIoVoTrait;

    /**
     * @var string
     */
    protected $object;

    /**
     * @var string
     */
    protected $callbackUrl;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @var bool
     */
    protected $active;

    /**
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return string
     */
    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
}