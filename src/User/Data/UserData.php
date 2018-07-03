<?php

namespace Simplon\Facebook\User\Data;

use Simplon\Helper\Data\Data;

/**
 * @package Simplon\Facebook\User\Data
 */
class UserData extends Data
{
    /**
     * @var string
     */
    protected $accessToken;
    /**
     * @var string
     */
    protected $appSecret;
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $firstName;
    /**
     * @var string
     */
    protected $middleName;
    /**
     * @var string
     */
    protected $lastName;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var array
     */
    protected $picture;

    /**
     * @param string $accessToken
     *
     * @return UserData
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return (string)$this->accessToken;
    }

    /**
     * @return string
     */
    public function getAppSecret(): string
    {
        return $this->appSecret;
    }

    /**
     * @param string $appSecret
     *
     * @return UserData
     */
    public function setAppSecret(string $appSecret): UserData
    {
        $this->appSecret = $appSecret;

        return $this;
    }

    /**
     * @param string $firstName
     *
     * @return UserData
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return (string)$this->firstName;
    }

    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     *
     * @return UserData
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * @param string $fullName
     *
     * @return UserData
     */
    public function setName($fullName)
    {
        $this->name = $fullName;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (string)$this->name;
    }

    /**
     * @param string $id
     *
     * @return UserData
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
     * @param string $lastName
     *
     * @return UserData
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return (string)$this->lastName;
    }

    /**
     * @return null|string
     */
    public function getPicture(): ?string
    {
        return $this->picture['data']['url'] ?? null;
    }
}
