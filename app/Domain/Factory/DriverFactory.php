<?php 

namespace App\Domain\Factory;

use App\Domain\Drivers\DriverInterface;
use App\Domain\Drivers\Email\GmailDriver;
use App\Domain\Drivers\Mobile\FirebaseDriver;
use App\Domain\Drivers\SMS\TwilioDriver;
use App\Domain\Strategy\MessageStrategyInterface; 

class DriverFactory
{  
    public function selectDriver($driverName) : DriverInterface
    {
        return match($driverName) {
            'gmail' => new GmailDriver,
            'firebase' => new FirebaseDriver,
            'twilio' => new TwilioDriver
        };
    }
}