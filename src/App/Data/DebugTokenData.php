<?php

namespace Simplon\Facebook\App\Data;

use Simplon\Facebook\FacebookConstants;
use Simplon\Helper\Data\Data;

/**
 * @package Simplon\Facebook\App\Vo
 */
class DebugTokenData extends Data
{
    /**
     * @var string
     */
    private $accessToken;
    /**
     * @var string
     */
    protected $appId;
    /**
     * @var string
     */
    protected $userId;
    /**
     * @var string|null
     */
    protected $profileId;
    /**
     * @var string
     */
    protected $application;
    /**
     * @var int
     */
    protected $expiresAt;
    /**
     * @var bool
     */
    protected $isValid;
    /**
     * @var int|null
     */
    protected $issuedAt;
    /**
     * @var array
     */
    protected $scopes;

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     *
     * @return DebugTokenData
     */
    public function setAccessToken(string $accessToken): DebugTokenData
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getAppId(): string
    {
        return $this->appId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return null|string
     */
    public function getProfileId(): ?string
    {
        return $this->profileId;
    }

    /**
     * @return string
     */
    public function getApplication(): string
    {
        return $this->application;
    }

    /**
     * @return int
     */
    public function getExpiresAt(): int
    {
        return $this->expiresAt;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @return int|null
     */
    public function getIssuedAt(): ?int
    {
        return $this->issuedAt;
    }

    /**
     * @return array
     */
    public function getScopes(): array
    {
        return $this->scopes;
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
     * @return bool
     */
    public function isShortTermToken()
    {
        if ($this->getIssuedAt() === null)
        {
            return true;
        }

        return false;
    }
}