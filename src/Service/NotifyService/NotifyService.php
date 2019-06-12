<?php

namespace App\Service\NotifyService;

use App\Service\Service;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormErrorIterator;

class NotifyService extends Service
{
    private $messages = [];

    private const SESSION_KEY = 'notifyMessages';

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->setUp();
    }

    public function addMessage(NotifyMessage $notifyMessage): void
    {
        $this->messages[] = $notifyMessage;
        $this->saveMessages();
    }

    public function cleanMessages(): void
    {
        $this->messages = [];
        $this->saveMessages();
    }

    public function getMessages(): array
    {
        $messages = $this->messages;

        $this->cleanMessages();
        return $messages;
    }

    public function addSuccess(string $message): void
    {
        $notifyMessage = new NotifyMessage(NotifyMessageType::SUCCESS, $message);
        $this->addMessage($notifyMessage);
    }

    public function addError(string $message): void
    {
        $notifyMessage = new NotifyMessage(NotifyMessageType::ERROR, $message);
        $this->addMessage($notifyMessage);
    }

    public function addFormErrors(FormErrorIterator $errors): void
    {
        if ($errors->count() <= 0) {
            return;
        }

        foreach ($errors as $error) {
            $notifyMessage = new NotifyMessage(NotifyMessageType::ERROR, $error->getMessage());
            $this->addMessage($notifyMessage);
        }
    }

    private function saveMessages(): void
    {
        $this->getSession()->set(self::SESSION_KEY, serialize($this->messages));
    }

    private function setUp(): void
    {
        $messages = $this->getSession()->get(self::SESSION_KEY, '');
        if (!empty($messages)) {
            $this->messages = unserialize($messages);
        }
    }
}