<?php

namespace Hztiny\TinyDingtalk\Api;

class UserApi
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
     * @param string $phone
     * @return \Hztiny\TinyDingtalk\Http\Response
     * @see https://open.dingtalk.com/document/orgapp/query-users-by-phone-number
     */
    public function getUserIdByPhone($phone)
    {
        return $this->client->http()->post('https://oapi.dingtalk.com/topapi/v2/user/getbymobile', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'query' => [
                'access_token' => $this->client->accessToken(),
            ],
            'json' => [
                'mobile' => $phone,
            ]
        ]);
    }

    /**
     * @param string $userId
     * @return \Hztiny\TinyDingtalk\Http\Response
     * @see https://open.dingtalk.com/document/orgapp/query-user-details
     */
    public function getUserByUserId($userId)
    {
        return $this->client->http()->post('https://oapi.dingtalk.com/topapi/v2/user/get', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'query' => [
                'access_token' => $this->client->accessToken(),
            ],
            'json' => [
                'userid' => $userId,
            ]
        ]);
    }

    /**
     * @param string $userToken
     * @param string $unionId
     * @return \Hztiny\TinyDingtalk\Http\Response
     * @see https://open.dingtalk.com/document/orgapp/dingtalk-retrieve-user-information
     */
    public function getUserByUserToken($userToken, $unionId = 'me')
    {
        return $this->client->http()->post("https://api.dingtalk.com/v1.0/contact/users/{$unionId}", [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'x-acs-dingtalk-access-token' => $userToken,
            ]
        ]);
    }
}
