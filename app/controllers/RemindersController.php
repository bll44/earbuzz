<?php

class RemindersController extends Controller {

	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function getRemind()
	{
		return View::make('password.remind');
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemind()
	{
		switch ($response = Password::remind(Input::only('email')))
		{
			case Password::INVALID_USER:
				return Redirect::back()
					->with('error', Lang::get($response));

			case Password::REMINDER_SENT:
				return Redirect::back()
					->with('status', Lang::get($response));
		}
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		if (is_null($token)) return Redirect::home();

		return View::make('password.reset')
			->with('token', $token);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset()
	{
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::reset($credentials, function($user, $password)
		{

		});

		// dd($response);

		if ($response === 'reminders.reset')
		{
			$user_finder = DB::table('users')
			->select('id', 'email')
			->where('email', '=', $credentials['email'])
			->get();

			foreach ($user_finder as $columns)
				{
					$user_id = $columns->id;
				}

			Auth::loginUsingId($user_id);



			return Redirect::to('/');
		}

		return Redirect::back()
			->with('error', Lang::get($response));
	}

}
