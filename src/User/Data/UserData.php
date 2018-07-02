<?php

namespace Simplon\Facebook\User\Data;

use Simplon\Facebook\FacebookRequests;
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
     * @param int $width
     * @param int $height
     *
     * @return string
     */
    public function getPictureUrl(int $width = 400, int $height = 400): string
    {
        $params = [
            'access_token' => $this->getAccessToken(),
            'app_secret'   => $this->getAppSecret(),
            'width'        => $width,
            'height'       => $height,
        ];

        return FacebookRequests::buildGraphUrl(
            FacebookRequests::buildPath('/{id}/picture', ['id' => $this->getId()], $params)
        );
    }

    /**
     * @param bool $snakeCase
     * @param int  $width
     * @param int  $height
     *
     * @return array
     */
    public function toArray(bool $snakeCase = true, int $width = 400, int $height = 400): array
    {
        $data = parent::toArray($snakeCase);
        $data['picture_url'] = $this->getPictureUrl($width, $height);

        return $data;
    }
}
