<?php

use Earbuzz\Forms\LoginForm;

class SessionsController extends BaseController {

	/**
	 * @var LoginForm
	 */
	private $LoginForm;

	function __construct(LoginForm $loginForm)
	{
		$this->loginForm = $loginForm;
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('sessions.create');

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::only('email', 'password');

		$this->loginForm->validate($input);

		if (Auth::attempt($input))
		{
			return Redirect::intended('/'); //url.intended
		}

		return Redirect::back()->withInput()->withFlashMessage('Invalid credentials provided');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id = null)
	{
		Auth::logout();
		Session::flush();
		Session::regenerate();

		return Redirect::home();
	}

	public function loginWithSocial($social_provider, $action = "")
	{
		// check URL segment
		if ($action == "auth") {

			// process authentication
			try {
				Session::set('provider', $social_provider);
				Hybrid_Endpoint::process();
			} catch (Exception $e) {
				// redirect back to http://URL/social/
				return Redirect::route('loginWith');
			}
			return;
		}

		try {
			// create a HybridAuth object
			$socialAuth = new Hybrid_Auth(app_path() . '/config/hybridauth.php');
			// authenticate with Provider
			$provider = $socialAuth -> authenticate($social_provider);
			// d($provider);die;

			// fetch user profile
			$userProfile = $provider -> getUserProfile();

		} catch(Exception $e) {
			// exception codes can be found on HybBridAuth's web site
			Session::flash('error_msg', $e -> getMessage());

			return Redirect::to('/login');
		}

		// Sends oauth request to controller
		$this -> createOAuthProfile($userProfile, $provider, $social_provider);

		// homepage redirect after authentication from oauth
		return Redirect::to('/');
	}

	public function generatePassword()
	{
		Hash::make('myPassword');
	}

	public function createOAuthProfile($userProfile, $provider, $social_provider) {

		//Grab username from authentication sources, attempts username, screen_name and displayName
		if (isset($userProfile -> username)){
			$username = strlen($userProfile -> username) > 0 ? $userProfile -> username : "";
		}

		if (isset($userProfile -> screen_name)){
			$username = strlen($userProfile -> screen_name) > 0 ? $userProfile -> screen_name : "";
		}

		if (isset($userProfile -> displayName)){
			$username = strlen($userProfile -> displayName) > 0 ? $userProfile -> displayName : "";
		}

		// Grabs email address from authentication source
		$email = strlen($userProfile -> email) > 0 ? $userProfile -> email : "";
		$email = strlen($userProfile -> emailVerified) > 0 ? $userProfile -> emailVerified : "";

		// Grabs authentication source type, such as Facebook or Twitter as a string
		$identifier = strlen($userProfile -> identifier) > 0 ? $userProfile -> identifier : "";

		// Makes a random password to store for the newly created user authentication
		$password = Hash::make('myPassword');

		// checks if email addres exists in database, if it doesn't it will add a new user and make them a profile
		if (User::where('email', $email) -> count() <= 0) {
			$authed = array('username' => $username, 'email' => $email, 'password' => $password);
			// 'provider' => $provider->adapter->providerId
			// 'provider_uid' => $identifier
			$user = User::create($authed);
			Auth::login($user);
			$user_id = $user ->id;
			$profile = new Profile;
			$profile->user_id = $user_id;
			$profile->display_name = $username;
			$profile->save();
			$user->profile()->save($profile);
			// User now logged in and authenticated for the first time
		}
		//Login user
		//Try to authenticate user
		try {
			$email_checker = User::where('email', $email) -> count();
			// Checks if email exists in database and finds it
			if ($email_checker = 1)
			{
				//User finder
				$user_id_finder=DB::table('users')
				->where('email','=',$email)
				->select('id')
				->get();

				// clean up object array to string
				$array = (array) $user_id_finder;
				$user_id_acquired = $array[0]->id;

				// manually log them in
				$user = User::find($user_id_acquired);
				Auth::login($user);

			}

			//At this point we may get many exceptions lets handle all user management and throttle exceptions
		} catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
			Session::flash('error_msg', 'Login field is required.');
			return Redirect::to('/login');
		} catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
			Session::flash('error_msg', 'Password field is required.');
			return Redirect::to('/login');
		} catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
			Session::flash('error_msg', 'Wrong password, try again.');
			return Redirect::to('/login');
		} catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
			Session::flash('error_msg', 'User was not found.');
			return Redirect::to('/login');
		} catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
			Session::flash('error_msg', 'User is not activated.');
			return Redirect::to('/login');
		} catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
			Session::flash('error_msg', 'User is suspended ');
			return Redirect::to('/login');
		} catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
			Session::flash('error_msg', 'User is banned.');
			return Redirect::to('/login');
		}

	}

}