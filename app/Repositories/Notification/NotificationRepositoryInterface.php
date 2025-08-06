<?php 

namespace App\Repositories\Notification;

use App\Models\Message;
use App\Models\User;

interface NotificationRepositoryInterface
{
    public function insert(User $user,Message $message) : Message;
}