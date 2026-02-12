<?php

namespace Hztiny\TinyDingtalk\Api;

class RobotApi
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
     * @param string $robotToken
     * @param string $robotSecret
     * @param \Hztiny\TinyDingtalk\Message\Message $message
     * @param bool $isAtAll
     * @param array $atUserIds
     * @param array $atMobiles
     * @return void
     * @see https://open.dingtalk.com/document/dingstart/custom-bot-to-send-group-chat-messages
     */
    public function sendGroupMessage($robotToken, $robotSecret, $message, $isAtAll = false, $atUserIds = [], $atMobiles = [])
    {
        $webhook = $this->buildSignedWebhook($robotToken, $robotSecret);

        $this->client->http()->post($webhook, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'msgtype' => $message->msgType(),
                $message->msgType() => $message->msgData(),
                'at' => [
                    'isAtAll' => $isAtAll,
                    'atUserIds' => $atUserIds,
                    'atMobiles' => $atMobiles,
                ]
            ],
        ]);
    }

    /**
     * @param string $robotToken
     * @param string $robotSecret
     * @return string
     */
    protected function buildSignedWebhook($robotToken, $robotSecret)
    {
        $timestamp = (int)(microtime(true) * 1000);

        $stringToSign = $timestamp . "\n" . $robotSecret;

        $hash = hash_hmac('sha256', $stringToSign, $robotSecret, true);

        $sign = urlencode(base64_encode($hash));

        return sprintf(
            'https://oapi.dingtalk.com/robot/send?access_token=%s&timestamp=%s&sign=%s',
            $robotToken,
            $timestamp,
            $sign
        );
    }
}
