<?php

namespace App\Http\Controllers\V1\Notification;

use App\Domain\MessageService;
use App\Domain\MessageServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SendNotificationController extends Controller
{
    public function __construct(protected MessageServiceInterface $messageService){}

    public function handle(Request $request)
    {
        $this->messageService->send(
            $request->validated('user'),
            $request->validated('message'),
            $request->validated('driver_name')
        );
    }
}
