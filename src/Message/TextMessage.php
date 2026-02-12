<?php

namespace Hztiny\TinyDingtalk\Message;

class TextMessage implements Message
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function msgType()
    {
        return 'text';
    }

    /**
     * @return array
     */
    public function msgData()
    {
        return [
            'content' => $this->content,
        ];
    }
}
