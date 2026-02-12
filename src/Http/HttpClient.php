<?php

namespace Hztiny\TinyDingtalk\Http;

class HttpClient
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * @param \GuzzleHttp\Client $http
     */
    public function __construct($http)
    {
        $this->http = $http;
    }

    /**
     * @param string $uri
     * @param array
     * @return \Hztiny\TinyDingtalk\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($uri, $options = [])
    {
        return new Response(
            $this->http->request('GET', $uri, $options)
        );
    }

    /**
     * @param string $uri
     * @param array
     * @return \Hztiny\TinyDingtalk\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($uri, $options = [])
    {
        return new Response(
            $this->http->request('POST', $uri, $options)
        );
    }
}
