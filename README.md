<pre>
     _                 _             
 ___(_)_ __ ___  _ __ | | ___  _ __  
/ __| | '_ ` _ \| '_ \| |/ _ \| '_ \ 
\__ \ | | | | | | |_) | | (_) | | | |
|___/_|_| |_| |_| .__/|_|\___/|_| |_|
                |_|                  
  __                _                 _    
 / _| __ _  ___ ___| |__   ___   ___ | | __
| |_ / _` |/ __/ _ \ '_ \ / _ \ / _ \| |/ /
|  _| (_| | (_|  __/ |_) | (_) | (_) |   &lt; 
|_|  \__,_|\___\___|_.__/ \___/ \___/|_|\_\
                                           
</pre>

Simplon/Facebook

-------------------------------------------------

## 1. Intro

This library helps you to communicate with ```Facebook's graph API```. It's goal is to get you quickly started by solving common use issues which unfortunately occur quite often within Facebook's graph API. 

-------------------------------------------------

## 2. Requirements

You will need a registered ```Facebook app``` in order to communicate with the API. Apps can be registered at [Facebooks Developers Portal](https://developers.facebook.com/). Simply have a look at ```My Apps``` and click ```Add a new app```.   

-------------------------------------------------

## 3. Install

Easy install via composer. Still no idea what composer is? Inform yourself [here](http://getcomposer.org).

```json
{
  "require": {
    "simplon/facebook": "*"
  }
}
```

-------------------------------------------------

## 4. User

The following paragraphs demonstrate how to authenticate a user against your facebook app. It will also show how to ```read an access token```, receive a ```long term access token``` and to ```retrieve a user's data```.

### 4.1. Request access token

We need a url to which we will redirect the user in order to authenticate our app with the requested permissions.
You will need a callback url for this. Facebook will redirect the user after handling the authentication process. This includes a cancellation as well.

For our little example we will go with the default permissions of ```public_profile```. Permissions depend on what you would like to do on behalf of the user.
[Here is a list](https://developers.facebook.com/docs/facebook-login/permissions#reference) of all possible permissions. 

```php
$appId = 'YOUR-APPID';
$appSecret = 'YOUR-APPSECRET';

// get a facebook app instance
$app = new FacebookApps($appId, $appSecret);

// we need a user instance
$user = new FacebookUsers($app, new FacebookPosts());

// callback url
$urlCallback = 'https://your-domain.com/callback/';

// we will fly with the default permissions: public_profile
$permissions = [];

// now lets build the url
$user->getUrlAuthentication($urlCallback, $permissions); // https://www.facebook.com/dialog/oauth?client_id=...

// redirect user to the given url...
```

After the user went through the authentication on Facebook's he/she will be redirected to your ```callback url```. If the user cancelled the process you will receive the following ```GET request```:

```
YOUR_CALLBACK_URL?
  error_reason=user_denied
  &error=access_denied
  &error_description=The+user+denied+your+request.
```

Otherwise you will receive an authentication code through the following ```GET request```:

```
YOUR_CALLBACK_URL?
  code=AQBggnsv...
```

To finally receive an ```access token``` in order to work with it we need to use the given ```code``` and our pre-defined ```callback url```:

```php
$appId = 'YOUR-APPID';
$appSecret = 'YOUR-APPSECRET';

// get a facebook app instance
$app = new FacebookApps($appId, $appSecret);

// we need a user instance
$user = new FacebookUsers($app, new FacebookPosts());

$code = 'AQBggnsv...'; // received code
$urlCallback = 'https://your-domain.com/callback/'; // this needs to be the exact same url as before

// request access token
$user->requestAccessTokenByCode($code, $urlCallback)

// print token
echo $user->getAccessToken(); // CAANc8o7bTTcBAPyTZCwW....
```

If you did not receive any ```FacebookException``` you should hold now a ```user's access token```.
You need to save the ```access token``` so that you can make use of it.

__This token has usally a lifetime of 1 to 2 hours.__ Read on to see how to request a ```long term access token```.

### 4.2. Access token information

Wanna see what data are attached to an access token? Do the following:

```php
$appId = 'YOUR-APPID';
$appSecret = 'YOUR-APPSECRET';

// your saved access token
$userAccessToken = 'CAANc8o7bTTcBAPyTZCwW....';

// get a facebook app instance
$app = new FacebookApps($appId, $appSecret);

// we need an app access token for this
$app->requestAccessToken();

// now we can have a look at the attached data for the user access token
$debugTokenVo = $app->getDebugTokenVo($userAccessToken); // have a look at the class DebugTokenVo

// is this a short term token?
$debugTokenVo->isShortTermToken(); // bool
```

### 4.3. Request a long term access token

Lets assume we received a token and by having a look at its attached data we figured that its a ```short term token```.
Turn this token into a ```60 days long term token```. When you received the new token make sure that you save it for later use.

```php
$appId = 'YOUR-APPID';
$appSecret = 'YOUR-APPSECRET';

// your saved access token
$userAccessToken = 'CAANc8o7bTTcBAPyTZCwW....';

// get a facebook app instance
$app = new FacebookApps($appId, $appSecret);

// we need a user instance
$user = new FacebookUsers($app, new FacebookPosts());

// request long term token
$user->setAccessToken($userAccessToken)->requestLongTermAccessToken();

// your new token
$user->getAccessToken(); // save the new token away
```

There won't be any harm done if you have already a ```long term token```.

### 4.4. Request user data

Alright, now that we have an access token we can do some requests - depending which [permissions you requested](https://developers.facebook.com/docs/facebook-login/permissions#reference).
In our case we have the default permission of ```public_profile```. The following example will request a user's data:

```php
$appId = 'YOUR-APPID';
$appSecret = 'YOUR-APPSECRET';

// your saved access token
$userAccessToken = 'CAANc8o7bTTcBAPyTZCwW....';

// get a facebook app instance
$app = new FacebookApps($appId, $appSecret);

// we need a user instance
$user = new FacebookUsers($app, new FacebookPosts());

// fetch user data
$facebookUserDataVo = $user->setAccessToken($userAccessToken)->getUserData(); // the class holds all data

// lets print the name
$facebookUserDataVo->getFullName(); // Foo Bar
```

-------------------------------------------------

## 5. Page

Soon to come.

## 6. Subscriptions

Soon to come.

-------------------------------------------------

# License
Simplon/Facebook is freely distributable under the terms of the MIT license.

Copyright (c) 2015 Tino Ehrich ([tino@bigpun.me](mailto:tino@bigpun.me))

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.