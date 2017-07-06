<?php

use Illuminate\Http\Request;

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
   return redirect(route('oauth.authorize'));
});

// the routes in this group require an active OAuth access token
Route::prefix('provision')->middleware(['access_token'])->group(function() {
   Route::get('new', 'ProvisionController@showNewUserScreen')->name('provision.new');
   Route::get('p', 'ProvisionController@provisionUser')->name('provision.provision');
});

// OAuth routes that tie into the Google API authorization functionality
Route::prefix('oauth')->group(function() {
   Route::get('authorize', 'OAuthController@authorizeUser')->name('oauth.authorize');
   Route::get('authorized', 'OAuthController@success')->name('oauth.success');
});