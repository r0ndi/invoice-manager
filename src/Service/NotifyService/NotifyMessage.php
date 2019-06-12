<?php

namespace App\Service\NotifyService;

class NotifyMessage
{
    private $type;
    private $message;

    public function __construct(int $type = NotifyMessageType::ERROR, string $message = '')
    {
        $this->setType($type);
        $this->setMessage($message);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(int $type)
    {
        $this->type = NotifyMessageType::getTypeName($type);
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }
}