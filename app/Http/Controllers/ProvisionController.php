<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events\SendEmailEvent;
use App\Models\EmailTemplate;
use App\Http\Requests\ProvisionUserRequest;

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

   public function provisionUser(ProvisionUserRequest $request) {
      // create the user in the organization
      $this->createUser($request);

      // send out the emails
      $this->sendEmails($request);

      return redirect()->back()->with('success',
         $request->get('first_name') . " " . $request->get('last_name') .
            " has been provisioned successfully!");
   }

   /**
    * Creates the new user in the organization.
    *
    * @param ProvisionUserRequest $request The provisioning request
    */
   protected function createUser(ProvisionUserRequest $request) {

   }

   /**
    * Sends the emails to the newly-provisioned user.
    *
    * @param ProvisionUserRequest $request The provisioning request
    */
   protected function sendEmails(ProvisionUserRequest $request) {
      // get my email address from my profile
      $svc = resolve('Google_Service_Gmail');
      $obj = $svc->users->getProfile('me');
      $from = $obj->emailAddress;

      // generate a random password for the email template
      $password = str_random(10);

      $emailTemplates = EmailTemplate::where('active', '1')->get();
      foreach($emailTemplates as $template) {
         if($template->isOrganization()) {
            $to = $request->get('org_email');
         }
         elseif($template->isExternal())
         {
            $to = $request->get('ext_email');
         }

         $subject = $template->subject;

         $body = str_replace("[FIRST_NAME]", $request->get('first_name'), $template->body);
         $body = str_replace("[EMAIL]", $request->get('org_email'), $body);
         $body = str_replace("[PASSWORD]", $password, $body);

         // fire the event to send the message
         event(new SendEmailEvent(
            $from,
            $to,
            $subject,
            $body
         ));
      }
   }
}
