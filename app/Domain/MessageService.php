<?php

namespace App\Domain;

use App\Domain\Factory\DriverFactory;
use App\Domain\MessageServiceInterface;
use App\Domain\Strategy\MessageContext;
use App\Models\Message;
use App\Models\User;
use App\Repositories\Notification\NotificationRepository;
use Illuminate\Contracts\Concurrency\Driver;

class MessageService implements MessageServiceInterface
{
    public function __construct(
        protected MessageContext $context,
        protected NotificationRepository $repository,
        protected DriverFactory $driverFactory
        )
    {}

    public function send(User $user, Message $message, string $driver_name): Message
    {
        $message = $this->repository->insert($user,$message);

        $driver = $this->driverFactory->selectDriver($driver_name);

        $this->context->setDriver($driver);

        return $this->context->send($user, $message);
    }
}    