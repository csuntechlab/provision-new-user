<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Google_Client;
use Google_Service_Directory;

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
        $this->app->singleton('Google_Client', function($app) {
           $client = new Google_Client();
           $client->setAuthConfig(storage_path('secret/client_secrets.json'));

           // add scope information
           $client->setIncludeGrantedScopes(true);   // incremental auth
           $client->addScope(Google_Service_Directory::ADMIN_DIRECTORY_USER);

           $client->setRedirectUri(url('oauth/authorized'));
           return $client;
        });
    }
}
