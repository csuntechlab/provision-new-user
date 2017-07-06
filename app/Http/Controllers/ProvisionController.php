<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProvisionController extends Controller
{
   /**
    * Shows the new user provisioning screen. If the user does not have an
    * access token, this redirects to the OAuth authorize route.
    *
    * @return View|RedirectResponse
    */
   public function showNewUserScreen() {
      if(!session('access_token')) {
         return redirect(route('oauth.authorize'));
      }

      return "New user screen";
   }
}
