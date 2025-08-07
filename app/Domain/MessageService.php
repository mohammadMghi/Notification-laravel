<?php

namespace App\Domain;

use App\Domain\Factory\DriverFactory;
use App\Domain\MessageServiceInterface;
use App\Domain\Strategy\MessageContext;
use App\Models\Message;
use App\Models\User;
use App\Repositories\Notification\NotificationRepository; 
use Illuminate\Support\Facades\Log;

class MessageService implements MessageServiceInterface
{
    public function __construct(
        protected MessageContext $context,
        protected NotificationRepository $repository,
        protected DriverFactory $driverFactory
        )
    {}

    public function send(User $user, Message $message, string $driver_name): Message|null
    {
        $maxAttempts = 3;
        $attempt = 0;
        $lastException = null;

        $message = $this->repository->insert($user,$message);

        $driver = $this->driverFactory->selectDriver($driver_name);

        $this->context->setDriver($driver);

        while($attempt < $maxAttempts)
        {
            try {   
                return $this->context->send($user, $message);
            }catch(\Throwable $e) {
                $attempt++;
                $lastException = $e;
            
                Log::warning("Notification attempt $attempt failed " . $e->getMessage());
            }
        }

        Log::error("Notification failed after {$maxAttempts} attempts.", ['exception' => $lastException]);
       
        return null;
    }
}    