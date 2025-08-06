<?php

namespace App\Domain;

use App\Domain\Factory\DriverFactory;
use App\Domain\MessageServiceInterface;
use App\Domain\Strategy\MessageContext;
use App\Models\Message;
use App\Models\User;
use App\Repositories\Notification\NotificationRepository;

class MessageService implements MessageServiceInterface
{
    public function __construct(protected MessageContext $context,protected NotificationRepository $repository)
    {}

    public function send(User $user, Message $message, string $driver_name)
    {
        $message = $this->repository->insert($user,$message);

        $driver = DriverFactory::selectDriver($driver_name);

        $this->context->setDriver($driver);

        return $this->context->send($user, $message);
    }
}