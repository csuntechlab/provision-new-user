<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events\SendEmailEvent;
use App\Models\EmailTemplate;
use App\Http\Requests\ProvisionUserRequest;

use Google_Service_Directory_User;
use Google_Service_Directory_UserName;

class ProvisionController extends Controller
{
   /**
    * Shows the new user provisioning screen.
    *
    * @return View
    */
   public function showNewUserScreen() {
      // resolve the organizational units for selection
      $orgUnits = [];
      $service = resolve('Google_Service_Directory');
      $ou = $service->orgunits->listOrgunits('my_customer');
      foreach($ou as $unit) {
         $orgUnits[$unit['orgUnitPath']] = $unit['name'];
      }

      // sort the organizational units by name in ascending order
      asort($orgUnits);
      array_unshift($orgUnits, "-- Please select an organizational unit --");

      return view('pages.provision.index', compact('orgUnits'));
   }

   /**
    * Provision a new user in the system.
    *
    * @param ProvisionUserRequest $request The provisioning request
    * @return RedirectResponse
    */
   public function provisionUser(ProvisionUserRequest $request) {
      // set the random password for later usage
      $password = str_random(10);

      // create the user in the organization
      $this->createUser($request, $password);

      // send out the emails
      $this->sendEmails($request, $password);

      // return back with a success message
      return redirect()->back()->with('success',
         $request->get('first_name') . " " . $request->get('last_name') .
            " has been provisioned successfully!");
   }

   /**
    * Creates the new user in the organization.
    *
    * @param ProvisionUserRequest $request The provisioning request
    * @param string $password The password generated for the new user
    */
   protected function createUser(ProvisionUserRequest $request, $password) {
      $service = resolve('Google_Service_Directory');
      $user = new Google_Service_Directory_User();

      // set the new user's name object
      $nameObj = new Google_Service_Directory_UserName();
      $nameObj->setFamilyName($request->get('last_name'));
      $nameObj->setGivenName($request->get('first_name'));
      $user->setName($nameObj);

      // set the new user attributes
      $user->setPassword($password);
      $user->setPrimaryEmail($request->get('org_email'));
      $user->setChangePasswordAtNextLogin(true);
      $user->setOrgUnitPath($request->get('org_unit'));

      // create the new user
      $resp = $service->users->insert($user);
      dd($resp);
   }

   /**
    * Sends the emails to the newly-provisioned user.
    *
    * @param ProvisionUserRequest $request The provisioning request
    * @param string $password The password generated for the new user
    */
   protected function sendEmails(ProvisionUserRequest $request, $password) {
      // get my email address from my profile
      $service = resolve('Google_Service_Gmail');
      $obj = $service->users->getProfile('me');
      $from = $obj->emailAddress;

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
