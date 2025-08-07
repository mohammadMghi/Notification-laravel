<?php 

namespace App\Domain\Drivers\SMS;

use App\Domain\Drivers\BaseDriver;
use App\Domain\Drivers\DriverInterface;
use App\Models\Message;
use App\Models\User;

class TwilioDriver extends BaseDriver implements DriverInterface
{
    public function send(User $user ,Message $message) : Message
    {
        return new Message;
    }
}