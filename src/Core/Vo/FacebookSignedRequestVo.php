<?php

namespace Simplon\Facebook\Core\Vo;

use Simplon\Helper\DataSetter;

/**
 * FacebookSignedRequestVo
 * @package Simplon\Facebook\Core\Vo
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class FacebookSignedRequestVo
{
    /**
     * @var int
     */
    private $expires;

    /**
     * @var int
     */
    private $issuedAt;

    /**
     * @var string
     */
    private $oauthToken;

    /**
     * @var int
     */
    private $pageId;

    /**
     * @var bool
     */
    private $pageAdmin;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $userCountry;

    /**
     * @var string
     */
    private $userLocale;

    /**
     * @var int
     */
    private $userAgeMin;

    /**
     * @var int
     */
    private $userAgeMax;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        (new DataSetter())
            ->assignField('expires', function ($val) { $this->setExpires($val); })
            ->assignField('issued_at', function ($val) { $this->setIssuedAt($val); })
            ->assignField('oauth_token', function ($val) { $this->setOauthToken($val); })
            ->assignField('page', function ($val) { $this->setPageData($val); })
            ->assignField('user_id', function ($val) { $this->setUserId($val); })
            ->assignField('user', function ($val) { $this->setUserData($val); })
            ->applyOn($data);
    }

    /**
     * @return int
     */
    public function getExpires()
    {
        return (int)$this->expires;
    }

    /**
     * @param int $expires
     *
     * @return FacebookSignedRequestVo
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * @return int
     */
    public function getIssuedAt()
    {
        return (int)$this->issuedAt;
    }

    /**
     * @param int $issuedAt
     *
     * @return FacebookSignedRequestVo
     */
    public function setIssuedAt($issuedAt)
    {
        $this->issuedAt = $issuedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getOauthToken()
    {
        return $this->oauthToken;
    }

    /**
     * @param string $oauthToken
     *
     * @return FacebookSignedRequestVo
     */
    public function setOauthToken($oauthToken)
    {
        $this->oauthToken = $oauthToken;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getPageAdmin()
    {
        return (bool)$this->pageAdmin;
    }

    /**
     * @return int
     */
    public function getPageId()
    {
        return (int)$this->pageId;
    }

    /**
     * @param array $page
     *
     * @return FacebookSignedRequestVo
     */
    public function setPageData(array $page)
    {
        $this->pageId = $page['id'];
        $this->pageAdmin = $page['admin'];

        return $this;
    }

    /**
     * @return int
     */
    public function getUserAgeMax()
    {
        return $this->userAgeMax;
    }

    /**
     * @return int
     */
    public function getUserAgeMin()
    {
        return $this->userAgeMin;
    }

    /**
     * @return string
     */
    public function getUserCountry()
    {
        return $this->userCountry;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return (int)$this->userId;
    }

    /**
     * @param int $userId
     *
     * @return FacebookSignedRequestVo
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @param array $user
     *
     * @return FacebookSignedRequestVo
     */
    public function setUserData(array $user)
    {
        $this->userCountry = $user['country'];
        $this->userLocale = $user['locale'];
        $this->userAgeMin = $user['age']['min'];

        if (isset($user['age']['max']))
        {
            $this->userAgeMax = $user['age']['max'];
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getUserLocale()
    {
        return $this->userLocale;
    }
}