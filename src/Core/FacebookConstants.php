<?php

namespace Simplon\Facebook\Core;

/**
 * FacebookConstants
 * @package Simplon\Facebook\Core
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class FacebookConstants
{
    const ERROR_REQUEST_CODE = 10000;
    const ERROR_REQUEST_EXCEPTION_SUBCODE = 10001;
    const ERROR_REQUEST_EXCEPTION_MESSAGE = 'Received an exception from Facebook.';

    const ERROR_CODE_FETCHING = 20000;

    const ERROR_MISSING_DATA_CODE = 30000;
    const ERROR_MISSING_ACCESSTOKEN_USER_SUBCODE = 30001;
    const ERROR_MISSING_ACCESSTOKEN_USER_MESSAGE = 'Missing UserAccessToken';
    const ERROR_MISSING_ACCESSTOKEN_PAGE_SUBCODE = 30002;
    const ERROR_MISSING_ACCESSTOKEN_PAGE_MESSAGE = 'Missing PageAccessToken';
    const ERROR_MISSING_ACCESSTOKEN_APP_SUBCODE = 30003;
    const ERROR_MISSING_ACCESSTOKEN_APP_MESSAGE = 'Missing AppAccessToken';

    const ERROR_USER_CODE = 40000;
    const ERROR_USER_INVALID_GRAPH_ACTION_TYPE_SUBCODE = 40001;
    const ERROR_USER_INVALID_GRAPH_ACTION_TYPE_MESSAGE = 'ActionType format is invalid. Valid format is: "namespace_app:like"';
    const ERROR_USER_MISSING_GRAPH_ITEM_ID_SUBCODE = 40002;
    const ERROR_USER_MISSING_GRAPH_ITEM_ID_MESSAGE = 'Please supply a graph item id';

    // --------------------------------------

    const ACCESSTOKEN_TYPE_PAGE = 'PAGE';
    const ACCESSTOKEN_TYPE_APP = 'APP';
    const ACCESSTOKEN_TYPE_USER = 'USER';

    // --------------------------------------

    const URL_DOMAIN_FACEBOOK = 'https://www.facebook.com';
    const URL_DOMAIN_GRAPH = 'https://graph.facebook.com';
    const PATH_LOGIN = '/dialog/oauth';
    const PATH_PAGETAB = '/dialog/pagetab';
    const PATH_DEBUG_TOKEN = '/debug_token';
    const PATH_OAUTH_ACCESSTOKEN = '/oauth/access_token';
    const PATH_ME = '/me';
    const PATH_ME_FRIENDS = '/me/friends';
    const PATH_ME_ACCOUNTS = '/me/accounts';
    const PATH_ME_FEED = '/me/feed';
    const PATH_OPEN_GRAPH_CREATE = '/me/{{actionType}}';
    const PATH_OPEN_GRAPH_DATA = '/{{itemId}}';
    const PATH_PAGE_DATA = '/{{pageId}}';
    const PATH_PAGE_FEED = '/{{pageId}}/feed';
    const PATH_PAGE_TABS = '/{{pageId}}/tabs';
    const PATH_POST = '/{{postId}}';
    const PATH_EVENT_DATA = '/{{eventId}}';
    const PATH_EVENT_CREATE = '/{{ownerIdentifier}}/events';

    // --------------------------------------

    const EVENT_OWNER_USER = 'USER';
    const EVENT_OWNER_PAGE = 'PAGE';
    const EVENT_OWNER_APP = 'APP';

    const EVENT_PRIVACY_TYPE_OPEN = 'OPEN';
    const EVENT_PRIVACY_TYPE_SECRET = 'SECRET';
    const EVENT_PRIVACY_TYPE_FRIENDS = 'FRIENDS';
    const EVENT_PRIVACY_TYPE_CLOSED = 'CLOSED';
}