<?php

class BillingController extends BaseController {

	public function buy() {

		return View::make('buy.index');

	}

	public function premium_buy() {

		$token = Input::get('stripe-token');

		Auth::user()->subscription('premium')->create($token);

		return Redirect::home();

	}

	public function cancel() {

		Auth::user()->subscription()->cancel();

		return Redirect::home();

	}

	public function resume() {

		return View::make('buy.resume');

	}

	public function resume_buy() {

		$token = Input::get('stripe-token');

		Auth::user()->subscription('premium')->resume($token);

		return Redirect::home();

	}

	public function checkCustomerStatus()
	{
		if(null === Auth::user()->stripe_id)
		{
			return json_encode(['status' => false]);
		}
		else
		{
			return json_encode(['status' => true]);
		}
	}

}