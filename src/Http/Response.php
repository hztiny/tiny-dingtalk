<?php

namespace Hztiny\TinyDingtalk\Http;

use Hztiny\TinyDingtalk\Exceptions\DingtalkException;

class Response
{
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * @var array|null
     */
    protected $decoded = null;

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function raw()
    {
        return $this->response;
    }

    /**
     * @return int
     */
    public function status()
    {
        return $this->response->getStatusCode();
    }

    /**
     * @return string
     */
    public function body()
    {
        return $this->response->getBody()->getContents();
    }

    /**
     * @return array
     */
    public function json()
    {
        if ($this->decoded !== null) {
            return $this->decoded;
        }

        $this->decoded = json_decode($this->body(), true) ?: [];

        return $this->decoded;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        $status = $this->status();

        if ($status < 200 || $status >= 300) {
            return false;
        }

        $data = $this->json();

        if (array_key_exists('errcode', $data)) {
            return (int) $data['errcode'] === 0;
        }

        if (array_key_exists('code', $data)) {
            return false;
        }

        return true;
    }

    /**
     * @return int|string|null
     */
    public function code()
    {
        $data = $this->json();

        return $data['errcode'] ?? $data['code'] ?? null;
    }

    /**
     * @return string|null
     */
    public function message()
    {
        $data = $this->json();

        return $data['errmsg'] ?? $data['message'] ?? null;
    }

    /**
     * @return self
     * @throws \Hztiny\TinyDingtalk\Exceptions\DingtalkException
     */
    public function throwIfFailed()
    {
        if (! $this->isSuccess()) {
            throw new DingtalkException(
                $this->message() ?: 'Dingtalk API Error',
            );
        }

        return $this;
    }

    /**
     * @return array
     * @throws \Hztiny\TinyDingtalk\Exceptions\DingtalkException
     */
    public function payload()
    {
        $data = $this->throwIfFailed()->json();

        return $data['result'] ?? $data;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     * @throws \Hztiny\TinyDingtalk\Exceptions\DingtalkException
     */
    public function field($key, $default = null)
    {
        $payload = $this->payload();

        return $payload[$key] ?? $default;
    }
}
