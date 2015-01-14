<?php

namespace Simplon\Facebook\Realtime;

use Simplon\Facebook\Core\Facebook;

/**
 * FacebookRealtime
 * @package Simplon\Facebook\Realtime
 * @author Tino Ehrich (tino@bigpun.me)
 */
class FacebookRealtime
{
    /**
     * @var Facebook
     */
    private $facebook;

    /**
     * @param Facebook $facebook
     */
    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * @return Facebook
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

}