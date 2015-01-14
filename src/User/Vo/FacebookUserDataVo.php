<?php

namespace Simplon\Facebook\User\Vo;

use Simplon\Helper\DataSetter;

/**
 * FacebookUserDataVo
 * @package Simplon\Facebook\User\Vo
 * @author Tino Ehrich (tino@bigpun.me)
 */
class FacebookUserDataVo
{
    /**
     * @var array
     */
    private $rawData;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $fullName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var string
     */
    private $urlProfile;

    /**
     * @var string
     */
    private $updatedAt;

    /**
     * @var int
     */
    private $timezone;

    /**
     * @var bool
     */
    private $verified;

    /**
     * @param array $data
     *
     * @return FacebookUserDataVo
     */
    public function setData(array $data)
    {
        (new DataSetter())
            ->assignField('id', function ($val) { $this->setId($val); })
            ->assignField('username', function ($val) { $this->setUsername($val); })
            ->assignField('first_name', function ($val) { $this->setFirstName($val); })
            ->assignField('last_name', function ($val) { $this->setLastName($val); })
            ->assignField('name', function ($val) { $this->setFullName($val); })
            ->assignField('email', function ($val) { $this->setEmail($val); })
            ->assignField('locale', function ($val) { $this->setLocale($val); })
            ->assignField('gender', function ($val) { $this->setGender($val); })
            ->assignField('link', function ($val) { $this->setUrlProfile($val); })
            ->assignField('updated_time', function ($val) { $this->setUpdatedAt($val); })
            ->assignField('timezone', function ($val) { $this->setTimezone($val); })
            ->assignField('verified', function ($val) { $this->setVerified($val); })
            ->applyOn($data);

        $this->setRawData($data);

        return $this;
    }

    /**
     * @return array
     */
    public function getRawData()
    {
        return (array)$this->rawData;
    }

    /**
     * @param string $accessToken
     *
     * @return FacebookUserDataVo
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
     * @param string $email
     *
     * @return FacebookUserDataVo
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return (string)$this->email;
    }

    /**
     * @param string $firstName
     *
     * @return FacebookUserDataVo
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
     * @param string $fullName
     *
     * @return FacebookUserDataVo
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return (string)$this->fullName;
    }

    /**
     * @param string $gender
     *
     * @return FacebookUserDataVo
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return (string)$this->gender;
    }

    /**
     * @param string $id
     *
     * @return FacebookUserDataVo
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
     * @return FacebookUserDataVo
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
     * @param string $locale
     *
     * @return FacebookUserDataVo
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return (string)$this->locale;
    }

    /**
     * @param string $urlProfile
     *
     * @return FacebookUserDataVo
     */
    public function setUrlProfile($urlProfile)
    {
        $this->urlProfile = $urlProfile;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrlProfile()
    {
        return (string)$this->urlProfile;
    }

    /**
     * @param int $timezone
     *
     * @return FacebookUserDataVo
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimezone()
    {
        return (int)$this->timezone;
    }

    /**
     * @param string $updatedTime
     *
     * @return FacebookUserDataVo
     */
    public function setUpdatedAt($updatedTime)
    {
        $this->updatedAt = $updatedTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return (string)$this->updatedAt;
    }

    /**
     * @param string $username
     *
     * @return FacebookUserDataVo
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return (string)$this->username;
    }

    /**
     * @param string $verified
     *
     * @return FacebookUserDataVo
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;

        return $this;
    }

    /**
     * @return bool
     */
    public function getVerified()
    {
        return (bool)$this->verified;
    }

    /**
     * @return bool
     */
    public function isVerified()
    {
        return $this->getVerified() === true;
    }

    /**
     * @param string $rawData
     *
     * @return FacebookUserDataVo
     */
    private function setRawData($rawData)
    {
        $this->rawData = $rawData;

        return $this;
    }
}
