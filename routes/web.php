<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
   return "Landing";
});


// OAuth routes that tie into the Google API authorization functionality
Route::prefix('oauth')->group(function() {
   Route::get('authorize', 'OAuthController@authorizeUser');
   Route::get('authorized', 'OAuthController@success');
});