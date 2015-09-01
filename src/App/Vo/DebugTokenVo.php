<?php

namespace Simplon\Facebook\App\Vo;

use Simplon\Facebook\FacebookConstants;
use Simplon\Helper\DataSetter;

/**
 * Class DebugTokenVo
 * @package Simplon\Facebook\App\Vo
 */
class DebugTokenVo
{
    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $profileId;

    /**
     * @var string
     */
    private $application;

    /**
     * @var int
     */
    private $expiresAt;

    /**
     * @var bool
     */
    private $isValid;

    /**
     * @var int
     */
    private $issuedAt;

    /**
     * @var array
     */
    private $scopes;

    /**
     * @param array $data
     *
     * @return DebugTokenVo
     */
    public function setData(array $data)
    {
        (new DataSetter())
            ->assignField('app_id', function ($val) { $this->setAppId($val); })
            ->assignField('application', function ($val) { $this->setApplication($val); })
            ->assignField('expires_at', function ($val) { $this->setExpiresAt($val); })
            ->assignField('issued_at', function ($val) { $this->setIssuedAt($val); })
            ->assignField('is_valid', function ($val) { $this->setIsValid($val); })
            ->assignField('scopes', function ($val) { $this->setScopes($val); })
            ->assignField('user_id', function ($val) { $this->setUserId($val); })
            ->assignField('profile_id', function ($val) { $this->setProfileId($val); })
            ->applyOn($data);

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     *
     * @return DebugTokenVo
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @param string $appId
     *
     * @return DebugTokenVo
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
     * @param string $profileId
     *
     * @return DebugTokenVo
     */
    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;

        return $this;
    }

    /**
     * @return string
     */
    public function getProfileId()
    {
        return (string)$this->profileId;
    }

    /**
     * @return string
     */
    public function getTokenType()
    {
        if ($this->getProfileId())
        {
            return FacebookConstants::ACCESSTOKEN_TYPE_PAGE;
        }
        elseif ($this->getUserId())
        {
            return FacebookConstants::ACCESSTOKEN_TYPE_USER;
        }

        return FacebookConstants::ACCESSTOKEN_TYPE_APP;
    }

    /**
     * @param string $application
     *
     * @return DebugTokenVo
     */
    public function setApplication($application)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * @return string
     */
    public function getApplication()
    {
        return (string)$this->application;
    }

    /**
     * @param int $expiresAt
     *
     * @return DebugTokenVo
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * @return int
     */
    public function getExpiresAt()
    {
        return (int)$this->expiresAt;
    }

    /**
     * @param bool $isValid
     *
     * @return DebugTokenVo
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return (bool)$this->isValid;
    }

    /**
     * @param int $issuedAt
     *
     * @return DebugTokenVo
     */
    public function setIssuedAt($issuedAt)
    {
        $this->issuedAt = $issuedAt;

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
     * @param array $scopes
     *
     * @return DebugTokenVo
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;

        return $this;
    }

    /**
     * @return array
     */
    public function getScopes()
    {
        return (array)$this->scopes;
    }

    /**
     * @param array $scopes
     *
     * @return array|bool
     */
    public function hasScopes(array $scopes)
    {
        $missing = [];
        $scopePermissions = $this->getScopes();

        foreach ($scopes as $scope)
        {
            if (!in_array($scope, $scopePermissions))
            {
                $missing[] = $scope;
            }
        }

        if (empty($missing))
        {
            return true;
        }

        return $missing;
    }

    /**
     * @param string $userId
     *
     * @return DebugTokenVo
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return (string)$this->userId;
    }

    /**
     * @return bool
     */
    public function isShortTermToken()
    {
        if (!$this->getIssuedAt())
        {
            return true;
        }

        return false;
    }
}