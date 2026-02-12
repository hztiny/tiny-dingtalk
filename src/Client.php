<?php

namespace Hztiny\TinyDingtalk;

use GuzzleHttp\Client as GuzzleHttpClient;
use Hztiny\TinyDingtalk\Auth\SimpleToken;
use Hztiny\TinyDingtalk\Auth\Token;
use Hztiny\TinyDingtalk\Http\HttpClient;

class Client
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var \Hztiny\TinyDingtalk\Http\HttpClient
     */
    protected $http;

    /**
     * @var \Hztiny\TinyDingtalk\Auth\Token
     */
    protected $token;

    /**
     * @var \Hztiny\TinyDingtalk\ApiManager
     */
    protected $api;

    /**
     * @param array $config
     * @param \Hztiny\TinyDingtalk\Auth\Token|null $token
     */
    public function __construct(array $config, ?Token $token = null)
    {
        $this->config = array_merge(['app_id' => '', 'app_secret' => ''], $config);

        $this->http = new HttpClient(new GuzzleHttpClient());

        $this->token = $token ?: new SimpleToken($this->appId(), $this->appSecret(), $this->http);
    }

    /**
     * @return string
     */
    public function appId()
    {
        return (string) $this->config['app_id'];
    }

    /**
     * @return string
     */
    public function appSecret()
    {
        return (string) $this->config['app_secret'];
    }

    /**
     * @return \Hztiny\TinyDingtalk\Http\HttpClient
     */
    public function http()
    {
        return $this->http;
    }

    /**
     * @return string
     */
    public function accessToken()
    {
        return $this->token->get();
    }

    /**
     * @return \Hztiny\TinyDingtalk\ApiManager
     */
    public function api()
    {
        if ($this->api === null) {
            $this->api = new ApiManager($this);
        }

        return $this->api;
    }
}
