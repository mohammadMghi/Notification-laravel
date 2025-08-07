<?php

namespace App\Domain\Strategy;

use App\Domain\Drivers\DriverInterface;
use App\Models\Message;
use App\Models\User;

interface MessageStrategyInterface
{
    public function setDriver(DriverInterface $driver);
    
    public function send(User $user,Message $message) : Message;
}