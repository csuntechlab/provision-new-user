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
      if(session('access_token')) {
         return redirect(route('provision.new'));
      }

      // we do not yet have an access token, so we need to create and
      // redirect to the auth URL
      $auth_url = $client->createAuthUrl();
      return redirect($auth_url);
   }

   /**
    * Redirects the user to the new user provisioning screen.
    *
    * @param Request $request The request object
    * @param Google_Client $client Google Admin SDK instance
    *
    * @return RedirectResponse
    */
   public function success(Request $request, Google_Client $client) {
      if(!$request->has('code')) {
         // we do not yet have a code returned from OAuth, so we need to create
         // and redirect to the auth URL
         $auth_url = $client->createAuthUrl();
         return redirect($auth_url);
      }

      // authenticate the client using the access code and then store the
      // access token in the session
      $client->authenticate($request->get('code'));
      session(['access_token' => $client->getAccessToken()]);

      // redirect to the new user provisioning screen
      return redirect(route('provision.new'));
   }
}
