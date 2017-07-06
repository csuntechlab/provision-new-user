<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Google_Service_Gmail;
use Google_Service_Gmail_Message;

class ProvisionController extends Controller
{
   /**
    * Shows the new user provisioning screen.
    *
    * @return View
    */
   public function showNewUserScreen() {
      return view('pages.provision.index');
   }

   public function provisionUser(Google_Service_Gmail $service) {
      // http://www.pipiscrew.com/2015/04/php-send-mail-through-gmail-api/
      $encodedSubject = base64_encode("Encoded Subject");

      $messageText = "To: Matthew Fritz <matthew.fritz@metalab.csun.edu>\r\n";
      $messageText .= "From: Matthew Fritz <matthew.fritz@metalab.csun.edu>\r\n";
      $messageText .= "Subject: =?utf-8?B?{$encodedSubject}?=\r\n";
      $messageText .= "MIME-Version: 1.0\r\n";
      $messageText .= "Content-Type: text/html; charset=utf-8\r\n";
      $messageText .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
      $messageText .= "This is the test message<br />\r\n";
      $messageText .= "This is another line on the test message<br />\r\n";

      $message = new Google_Service_Gmail_Message();
      $raw = rtrim(strtr(base64_encode($messageText), '+/', '-_'), '=');
      $message->setRaw($raw);

      $sent = $service->users_messages->send("matthew.fritz@metalab.csun.edu", $message);
      dd($sent);
   }
}
