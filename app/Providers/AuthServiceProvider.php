<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Validator::extend('eventbrite', function ($attribute, $value, $parameters, $validator) {
            $http = new Client(['headers' => ['Authorization' => 'Bearer ' . config('eventbrite.token')]]);

            $response = $http->get(config('eventbrite.url') . $value);

            $eventBrite = json_decode((string) $response->getBody());

            if ($response->getStatusCode() == 200 && $eventBrite->event_id == config('eventbrite.event_id')) {
                return true;
            }

            return false;
        });
    }
}
