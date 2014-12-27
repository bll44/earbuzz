<?php

namespace Earbuzz\Billing;

use Stripe;
use Stripe_Charge;
use Stripe_Customer;
use Stripe_InvalidRequestError;
use Stripe_CardError;
use Config;
use Exception;

class StripeBilling implements BillingInterface {

    public function __construct()
    {
        Stripe::setApiKey(Config::get('services.stripe.secret'));
    }
    public function charge(array $data)
    {
        try
        {
            $customer = Stripe_Customer::create([
                'card' => $data['token'],
                'email' => $data['email'],
                'description' => $data['description']
            ]);
            return Stripe_Charge::create([
                'amount' => $data['amount'] * 100, // amount * 100 to get the proper amount in cents
                'currency' => 'usd',
                'customer' => $customer->id
            ]);
            // return $customer->id;
        }
        catch (Stripe_InvalidRequestError $e)
        {
            // Invalid parameters were supplied to Stripe's API
            throw new Exception($e->getMessage());
        }
        catch(Stripe_CardError $e)
        {
            // Card was declined
            throw new Exception($e->getMessage());
        }
    }
}