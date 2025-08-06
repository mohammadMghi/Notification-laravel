<?php 

namespace App\Repositories\Notification;

use App\Models\Message;
use App\Models\User;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function insert(User $user, Message $message) : Message
    {
        return new Message();
    }
} 