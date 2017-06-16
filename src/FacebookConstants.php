<?php

namespace Simplon\Facebook;

/**
 * Class FacebookConstants
 * @package Simplon\Facebook
 */
class FacebookConstants
{
    const ERROR_CODE_REQUEST = 1000;

    const ACCESSTOKEN_TYPE_PAGE = 'PAGE';
    const ACCESSTOKEN_TYPE_APP = 'APP';
    const ACCESSTOKEN_TYPE_USER = 'USER';

    const URL_FACEBOOK = 'https://www.facebook.com';
    const URL_GRAPH = 'https://graph.facebook.com';

    const PATH_OAUTH = '/dialog/oauth';
    const PATH_PAGETAB = '/dialog/pagetab';
    const PATH_DEBUG_TOKEN = '/debug_token';
    const PATH_OAUTH_ACCESSTOKEN = '/oauth/access_token';
    const PATH_GRAPH_ITEM = '/{id}';
    const PATH_ME = '/me';
    const PATH_ME_FRIENDS = '/me/friends';
    const PATH_ME_ACCOUNTS = '/me/accounts';
    const PATH_ME_FEED = '/me/feed';
    const PATH_ME_STORY_CREATE = '/me/{action_type}';
    const PATH_ME_PERMISSIONS = '/me/permissions';
    const PATH_APP_STORY_OBJECT_CREATE = '/app/objects/{object_type}';
    const PATH_POST_EDGE = '/{edge_id}/feed';
    const PATH_PHOTO_EDGE = '/{edge_id}/photos';
    const PATH_PAGE_TABS = '/{page_id}/tabs';
    const PATH_APP_SUBSCRIPTIONS = '/{app_id}}/subscriptions';
    const PATH_OBJECT = '/';

    /**
     * @var string
     */
    private static $version = '2.9';

    /**
     * @param string $version
     */
    public static function setVersion(string $version): void
    {
        self::$version = $version;
    }

    /**
     * @return string
     */
    public static function getVersion(): string
    {
        return self::$version;
    }
}