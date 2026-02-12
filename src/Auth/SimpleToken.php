<?php

namespace Hztiny\TinyDingtalk\Auth;

class SimpleToken implements Token
{
    /**
     * @var string
     */
    protected $appId;

    /**
     * @var string
     */
    protected $appSecret;

    /**
     * @var \Hztiny\TinyDingtalk\Http\HttpClient
     */
    protected $httpClient;

    /**
     * @param string $appId
     * @param string $appSecret
     * @param \Hztiny\TinyDingtalk\Http\HttpClient $httpClient
     */
    public function __construct($appId, $appSecret, $httpClient)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->httpClient = $httpClient;
    }

    /**
     * @return string
     * @throws \Hztiny\TinyDingtalk\Exceptions\DingtalkException
     * @see https://open.dingtalk.com/document/orgapp/obtain-the-access_token-of-an-internal-app
     */
    public function get()
    {
        $response = $this->httpClient->post('https://api.dingtalk.com/v1.0/oauth2/accessToken', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'appKey' => $this->appId,
                'appSecret' => $this->appSecret,
            ],
        ]);

        return (string) $response->field('accessToken');
    }
}
