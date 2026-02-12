<?php

namespace Hztiny\TinyDingtalk;

use Hztiny\TinyDingtalk\Api\OauthApi;
use Hztiny\TinyDingtalk\Api\RobotApi;
use Hztiny\TinyDingtalk\Api\UserApi;

class ApiManager
{
    /**
     * @var \Hztiny\TinyDingtalk\Client
     */
    protected $client;

    /**
     * @var array
     */
    protected array $apis = [];

    /**
     * @param \Hztiny\TinyDingtalk\Client $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @return \Hztiny\TinyDingtalk\Api\OauthApi
     */
    public function oauth()
    {
        return $this->getApi(OauthApi::class);
    }

    /**
     * @return \Hztiny\TinyDingtalk\Api\UserApi
     */
    public function user()
    {
        return $this->getApi(UserApi::class);
    }

    /**
     * @return \Hztiny\TinyDingtalk\Api\RobotApi
     */
    public function robot()
    {
        return $this->getApi(RobotApi::class);
    }

    /**
     * @param string $class
     * @return object
     */
    protected function getApi($class)
    {
        if (! isset($this->apis[$class])) {
            $this->apis[$class] = new $class($this->client);
        }

        return $this->apis[$class];
    }
}
