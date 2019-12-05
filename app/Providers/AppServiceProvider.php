<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
		   Schema::defaultStringLength(191); //NEW: Increase StringLength
		   Client::creating(function (Client $client) {
			$client->incrementing = false;
			$client->id = \Ramsey\Uuid\Uuid::uuid4()->toString();
});
Client::retrieved(function (Client $client) {
    $client->incrementing = false;
});
    }
}
