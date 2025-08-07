<?php

namespace Tests\Unit;

use App\Domain\Drivers\Email\GmailDriver;
use App\Domain\Exceptions\MessageNotificationFailedException;
use App\Domain\Factory\DriverFactory;
use App\Domain\MessageService;
use Tests\TestCase;
use App\Domain\Strategy\MessageContext;
use App\Models\Message;
use App\Models\User;
use App\Repositories\Notification\NotificationRepository;
use Mockery; 

class MessageServiceTest extends TestCase
{
    public function tearDown(): void
    {   
        Mockery::close(); 
        parent::tearDown();
    }

    public function test_send_message(): void
    {
        $user = new User();
        $message = new Message();
        $storedMessage = clone $message;

        $context = Mockery::mock(MessageContext::class);
        $reoisitory = Mockery::mock(NotificationRepository::class);
        $driverFactory = Mockery::mock(DriverFactory::class);
        $gmailDriver = Mockery::mock(GmailDriver::class);
        $reoisitory->shouldReceive('insert')
            ->once()
            ->andReturn($message);

        $driverFactory->shouldReceive('selectDriver')
            ->once()
            ->with('gmail')
            ->andReturn($gmailDriver);
        
        $context->shouldReceive('setDriver')
            ->once()
            ->with($gmailDriver);

        $context->shouldReceive('send')
            ->once()
            ->with($user,$message)
            ->andReturn($storedMessage);

        $messageService = new MessageService($context,$reoisitory,$driverFactory);

        $result = $messageService->send($user , $message,'gmail');
        
        $this->assertEquals($storedMessage,$result);
    }

    public function test_send_message_failed()
    {
        $user = new User();
        $message = new Message();
        $storedMessage = clone $message;

        $context = Mockery::mock(MessageContext::class);
        $reoisitory = Mockery::mock(NotificationRepository::class);
        $driverFactory = Mockery::mock(DriverFactory::class);
        $gmailDriver = Mockery::mock(GmailDriver::class);
        $reoisitory->shouldReceive('insert')
            ->once()
            ->andReturn($message);

        $driverFactory->shouldReceive('selectDriver')
            ->once()
            ->with('gmail')
            ->andReturn($gmailDriver);
        
        $context->shouldReceive('setDriver')
            ->once()
            ->with($gmailDriver);

        $context->shouldReceive('send')
            ->times(3)
            ->with($user,$message)
            ->andThrow(new MessageNotificationFailedException);

        $messageService = new MessageService($context,$reoisitory,$driverFactory);

        $result = $messageService->send($user , $message,'gmail');
        
        $this->assertEquals(null,$result);
    }

    public function test_send_message_with_one_failed()
    {
        $user = new User();
        $message = new Message();
        $storedMessage = clone $message;

        $context = Mockery::mock(MessageContext::class);
        $reoisitory = Mockery::mock(NotificationRepository::class);
        $driverFactory = Mockery::mock(DriverFactory::class);
        $gmailDriver = Mockery::mock(GmailDriver::class);
        $reoisitory->shouldReceive('insert')
            ->once()
            ->andReturn($message);

        $driverFactory->shouldReceive('selectDriver')
            ->once()
            ->with('gmail')
            ->andReturn($gmailDriver);
        
        $context->shouldReceive('setDriver')
            ->once()
            ->with($gmailDriver);

        $context->shouldReceive('send')
            ->once()
            ->with($user,$message)
            ->andThrow(new MessageNotificationFailedException);

        $context->shouldReceive('send')
            ->once()
            ->with($user,$message)
            ->andThrow($storedMessage);


        $messageService = new MessageService($context,$reoisitory,$driverFactory);

        $result = $messageService->send($user , $message,'gmail');
        
        $this->assertEquals($storedMessage,$result);
    }
}
 