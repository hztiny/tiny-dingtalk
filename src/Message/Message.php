<?php

namespace Hztiny\TinyDingtalk\Message;

interface Message
{
    /**
     * @return string
     */
    public function msgType();

    /**
     * @return array
     */
    public function msgData();
}
