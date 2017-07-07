<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Google_Client;
use Google_Service_Directory;
use Google_Service_Gmail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // instance of the Google API client
        $this->app->singleton('Google_Client', function($app) {
           $client = new Google_Client();
           $client->setAccessType('offline');
           $client->setAuthConfig(storage_path('secret/client_secrets.json'));

           // add scope information
           $client->setIncludeGrantedScopes(true);   // incremental auth
           $client->addScope(Google_Service_Directory::ADMIN_DIRECTORY_USER);
           $client->addScope(Google_Service_Directory::ADMIN_DIRECTORY_ORGUNIT_READONLY);
           $client->addScope(Google_Service_Gmail::GMAIL_COMPOSE);

           $client->setRedirectUri(route('oauth.success'));
           return $client;
        });

        // instance of the Directory service to be used with the Google API client
        $this->app->singleton('Google_Service_Directory', function($app) {
           return new Google_Service_Directory($app->make('Google_Client'));
        });

        // instance of the Gmail service to be used with the Google API client
        $this->app->singleton('Google_Service_Gmail', function($app) {
           return new Google_Service_Gmail($app->make('Google_Client'));
        });
    }
}
