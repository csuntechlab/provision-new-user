<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events\SendEmailEvent;

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

   public function provisionUser() {
      // fire the event to send the message
      event(new SendEmailEvent(
         "matthew.fritz@metalab.csun.edu",
         "matthew.fritz@metalab.csun.edu",
         "Using Event Handler",
         "Line one<br />Line two"
      ));
   }
}
