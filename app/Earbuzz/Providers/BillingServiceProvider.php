<?php namespace Earbuzz\Providers;

use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('Earbuzz\Billing\BillingInterface', 'Earbuzz\Billing\StripeBilling');
    }
}