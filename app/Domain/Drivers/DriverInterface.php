<?php 

namespace App\Domain\Drivers;

use App\Models\Message;
use App\Models\User;

interface DriverInterface
{
    public function send(User $user ,Message $message);
}