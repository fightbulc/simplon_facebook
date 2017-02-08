<?php

namespace Simplon\Facebook\Objects;

use Simplon\Facebook\App\FacebookApps;
use Simplon\Facebook\FacebookConstants;
use Simplon\Facebook\FacebookException;
use Simplon\Facebook\FacebookRequests;
use Simplon\Facebook\Objects\Vo\FacebookObjectVo;
use Simplon\Helper\Helper;

/**
 * @package Simplon\Facebook\Objects
 */
class FacebookObjects
{
    /**
     * @var FacebookApps
     */
    private $app;

    /**
     * @param FacebookApps $app
     */
    public function __construct(FacebookApps $app)
    {
        $this->app = $app;
    }

    /**
     * @param string $url
     *
     * @return FacebookObjectVo
     * @throws FacebookException
     */
    public function createCrawl($url)
    {
        return $this->crawl($url);
    }

    /**
     * @param string $objectId
     *
     * @return FacebookObjectVo
     * @throws FacebookException
     */
    public function updateCrawl($objectId)
    {
        return $this->crawl($objectId);
    }

    /**
     * @param string $object
     *
     * @return FacebookObjectVo
     * @throws FacebookException
     */
    protected function crawl($object)
    {
        $url = Helper::urlRender(
            [FacebookConstants::URL_GRAPH, FacebookConstants::PATH_OBJECT],
            [],
            [
                'id'           => $object,
                'scrape'       => true,
                'access_token' => $this->app->getAccessToken(),
            ]
        );

        $response = FacebookRequests::post($url);

        return (new FacebookObjectVo())->setData($response);
    }
}