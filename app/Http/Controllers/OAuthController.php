<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Google_Client;

class OAuthController extends Controller
{
   /**
    * Redirects the user to the Google OAuth authorization screen.
    *
    * @param Google_Client $client Google Admin SDK instance
    * @return RedirectResponse
    */
   public function authorizeUser(Google_Client $client) {
      // create and redirect to the authorization URL
      $auth_url = $client->createAuthUrl();
      return redirect($auth_url);
   }

   public function success() {
      return "Success!";
   }
}
