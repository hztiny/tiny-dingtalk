<?php

namespace Hztiny\TinyDingtalk\Api;

class OauthApi
{
    /**
     * @var \Hztiny\TinyDingtalk\Client
     */
    protected $client;

    /**
     * @param \Hztiny\TinyDingtalk\Client $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @param string $redirectUri
     * @param string|null $state
     * @return string
     * @see https://open.dingtalk.com/document/orgapp/tutorial-obtaining-user-personal-information
     */
    public function getAuthorizationUrl($redirectUri, $state = null)
    {
        $query = [
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'client_id' => $this->client->appId(),
            'scope' => 'openid',
            'state' => $state,
            'prompt' => 'consent',
        ];

        return sprintf('https://login.dingtalk.com/oauth2/auth?%s', http_build_query($query));
    }

    /**
     * @param string $authCode
     * @return \Hztiny\TinyDingtalk\Http\Response
     * @see https://open.dingtalk.com/document/orgapp/obtain-user-token
     */
    public function getUserToken($authCode)
    {
        return $this->client->http()->post('https://api.dingtalk.com/v1.0/oauth2/userAccessToken', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'clientId' => $this->client->appId(),
                'clientSecret' => $this->client->appSecret(),
                'code' => $authCode,
                'refreshToken' => '',
                'grantType' => 'authorization_code',
            ]
        ]);
    }
}
