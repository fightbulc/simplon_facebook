<?php

namespace Simplon\Facebook\User\Data;

use Simplon\Helper\Data\Data;

/**
 * @package Simplon\Facebook\User\Data
 */
class UserData extends Data
{
    /**
     * @var array
     */
    protected $data;
    /**
     * @var string
     */
    protected $accessToken;
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $username;
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
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $locale;
    /**
     * @var string
     */
    protected $location;
    /**
     * @var string
     */
    protected $gender;
    /**
     * @var array
     */
    protected $ageRange;
    /**
     * @var string
     */
    protected $link;
    /**
     * @var string
     */
    protected $birthday;
    /**
     * @var string
     */
    protected $updatedAt;
    /**
     * @var int
     */
    protected $timezone;
    /**
     * @var bool
     */
    protected $verified;

    /**
     * @param string $accessToken
     *
     * @return UserData
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        // cache in raw data
        $this->data['access_token'] = $accessToken;

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
     * @return UserData
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
     * @param string $gender
     *
     * @return UserData
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
     * @param string $locale
     *
     * @return UserData
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
     * @return UserData
     */
    public function setLink($urlProfile)
    {
        $this->link = $urlProfile;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return (string)$this->link;
    }

    /**
     * @param int $timezone
     *
     * @return UserData
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
     * @return UserData
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
     * @return UserData
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
     * @return UserData
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
     * @return UserData
     */
    protected function setRawData($rawData)
    {
        $this->data = $rawData;

        return $this;
    }

    /**
     * @return array
     */
    public function getAgeRange()
    {
        return $this->ageRange;
    }

    /**
     * @return int|null
     */
    public function getAgeRangeMin()
    {
        if (isset($this->ageRange['min']))
        {
            return (int)$this->ageRange['min'];
        }

        return null;
    }

    /**
     * @return int|null
     */
    public function getAgeRangeMax()
    {
        if (isset($this->ageRange['max']))
        {
            return (int)$this->ageRange['max'];
        }

        return null;
    }

    /**
     * @param array $ageRange
     *
     * @return UserData
     */
    public function setAgeRange($ageRange)
    {
        $this->ageRange = $ageRange;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     *
     * @return UserData
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return string
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param string $birthday
     *
     * @return UserData
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }
}
