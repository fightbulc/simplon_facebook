<?php

namespace Simplon\Facebook\App\Data;

use Simplon\Helper\Data\Data;

/**
 * @package Simplon\Facebook\App\Data
 */
class SignedRequestData extends Data
{
    /**
     * @var int
     */
    protected $expires;
    /**
     * @var int
     */
    protected $issuedAt;
    /**
     * @var string
     */
    protected $oauthToken;
    /**
     * @var array
     */
    protected $page;
    /**
     * @var array
     */
    protected $user;
    /**
     * @var int
     */
    protected $userId;
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
     * @var int
     */
    private $pageId;
    /**
     * @var bool
     */
    private $pageAdmin;

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
     * @return SignedRequestData
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
     * @return SignedRequestData
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
     * @return SignedRequestData
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
     * @return SignedRequestData
     */
    public function setPage(array $page)
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
     * @return SignedRequestData
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @param array $user
     *
     * @return SignedRequestData
     */
    public function setUser(array $user)
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