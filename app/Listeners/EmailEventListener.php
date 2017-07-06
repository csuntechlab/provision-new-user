<?php

namespace App\Listeners;

use App\Events\SendEmailEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Google_Service_Gmail;
use Google_Service_Gmail_Message;

class EmailEventListener
{
    protected $service;

    /**
     * Create the event listener.
     *
     * @param Google_Service_Gmail $service Gmail API instance
     */
    public function __construct(Google_Service_Gmail $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param  SendEmailEvent  $event
     * @return void
     */
    public function handle(SendEmailEvent $event)
    {
       // http://www.pipiscrew.com/2015/04/php-send-mail-through-gmail-api/
       $encodedSubject = base64_encode($event->subject);

       $messageText = "To: {$event->to}\r\n";
       $messageText .= "From: {$event->from}\r\n";
       $messageText .= "Subject: =?utf-8?B?{$encodedSubject}?=\r\n";
       $messageText .= "MIME-Version: 1.0\r\n";
       $messageText .= "Content-Type: text/plain; charset=utf-8; format=flowed\r\n";
       $messageText .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
       $messageText .= "{$event->body}\r\n";

       $message = new Google_Service_Gmail_Message();
       $raw = rtrim(strtr(base64_encode($messageText), '+/', '-_'), '=');
       $message->setRaw($raw);

       // send out the email using the currently-authenticated user
       $this->service->users_messages->send('me', $message);
    }
}
