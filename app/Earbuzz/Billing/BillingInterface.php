<?php namespace Earbuzz\Billing;

interface BillingInterface {
	
    public function charge(array $data);
}