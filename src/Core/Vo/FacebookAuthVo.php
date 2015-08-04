<?php

namespace Simplon\Facebook\Core\Vo;

use Simplon\Helper\DataSetter;

/**
 * FacebookAuthVo
 * @package Simplon\Facebook\Core\Vo
 * @author Tino Ehrich (tino@bigpun.me)
 */
class FacebookAuthVo
{
    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $appSecret;

    /**
     * @param array $data
     *
     * @return FacebookAuthVo
     */
    public function setData(array $data)
    {
        (new DataSetter())
            ->assignField('appId', function ($val) { $this->setAppId($val); })
            ->assignField('appSecret', function ($val) { $this->setAppSecret($val); })
            ->applyOn($data);

        return $this;
    }

    /**
     * @param mixed $appId
     *
     * @return FacebookAuthVo
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;

        return $this;
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return (string)$this->appId;
    }

    /**
     * @param mixed $appSecret
     *
     * @return FacebookAuthVo
     */
    public function setAppSecret($appSecret)
    {
        $this->appSecret = $appSecret;

        return $this;
    }

    /**
     * @return string
     */
    public function getAppSecret()
    {
        return (string)$this->appSecret;
    }
}