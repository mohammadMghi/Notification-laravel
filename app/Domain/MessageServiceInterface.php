<?php 

namespace App\Domain;

use App\Models\Message;
use App\Models\User;

interface MessageServiceInterface 
{
    public function send(User $user , Message $message, string $driver_name) : Message|null;
}