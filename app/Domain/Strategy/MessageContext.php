<?php 

namespace App\Domain\Strategy;

use App\Domain\Drivers\DriverInterface;
use App\Models\Message;
use App\Models\User;

class MessageContext implements MessageStrategyInterface
{
    private DriverInterface $driver;

    public function setDriver(DriverInterface $driver)
    {
        $this->driver = $driver;
    }
     
    /**
     * Sned message
     * @param \App\Models\User $user
     * @param \App\Models\Message $message
     * @return Message
     */
    public function send(User $user, Message $message): Message
    {
        return $this->driver->send($user , $message);
    }
}