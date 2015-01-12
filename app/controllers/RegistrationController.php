<?php

use Earbuzz\Forms\RegistrationForm;

class RegistrationController extends BaseController {

	/**
	 * @var RegistrationForm, Artist, Fan, User
	 */
	protected $registrationForm, $artist, $fan, $user;

	function __construct(RegistrationForm $registrationForm, User $user, Artist $artist, Fan $fan)
	{
		$this->registrationForm = $registrationForm;
		$this->user = $user;
		$this->artist = $artist;
		$this->fan = $fan;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store_fan()
	{

		$input = Input::only('displayname', 'username', 'email', 'password', 'password_confirmation', 'type');

		$this->registrationForm->validate($input);

		$user = User::create($input);

		$user->type = 'fan';

		$user->save();

		Auth::login($user);

		$user_id = $user->id;

		$profile = new Profile;

		$profile->user_id = $user_id;

		$profile->save();

		$sk = new StreamingKey;

		$sk->user_id = $user_id;

		$sk->save();

		return Redirect::home();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store_artist()
	{
		$input = Input::only('displayname', 'username', 'email', 'password', 'password_confirmation', 'type');

		$this->registrationForm->validate($input);

		// Create the new user record in the database
		$user = User::create($input);
		$user->type = 'artist';
		$user->save();

		$input = (object) $input;

		Auth::login($user);

		$user_id = $user->id;

		// Create the standard user profile for the artist
		$profile = new Profile;
		$profile->user_id = $user_id;
		$profile->display_name = $input->displayname;
		$profile->save();

		// Assign a streaming key to the new artist
		$sk = new StreamingKey;
		$sk->user_id = $user_id;
		$sk->save();

		// Create the artist profile in the database
		$artist = new Artist;
		$artist->user_id = $user_id;
		$artist->name = $input->username;
		$artist->save();

		Session::put('complete_artist_info', true);

		return Redirect::home();
	}

	public function profileSelection()
	{
		return View::make('registration.profile_selection');
	}

	public function createArtist()
	{
		return View::make('registration.create_artist');
	}

	public function createFan()
	{
		return View::make('registration.create_fan');
	}

	/**
 * Login user with facebook
 *
 * @return void
 */

public function loginWithFacebook() {

	// get data from input
	$code = Input::get( 'code' );

	// get fb service
	$fb = OAuth::consumer( 'Facebook' );

	// check if code is valid

	// if code is provided get user data and sign in
	if ( !empty( $code ) ) {

		// This was a callback request from facebook, get the token
		$token = $fb->requestAccessToken( $code );

		// Send a request with it
		$result = json_decode( $fb->request( '/me' ), true );

		// dd($result);
		$answer = 0;

		// check database to see if unique ID exists
		$unique_checker = DB::select('select * from users where provider_uid = '. $result['id'] );

		foreach ($unique_checker as $finder) {
			$answer = $finder->provider_uid;
			$user_id = $finder->id;
		}

		// if it exists log them in
		if ($answer === $result['id']){
			// dd('log in command here');
			Auth::loginUsingId($user_id);
			return Redirect::home();
		}

		// if user does not exist - redirect to registration because they need to pick fan or artist
		// $user = new User;
		// $user->username = $result['name'];
		// $user->displayname = $result['name'];
		// $user->provider = 'facebook';
		// $user->provider_uid = $result['id'];
		// $user->save();
		// Auth::login($user);
		// $user_id = $user->id;
		// $profile = new Profile;
		// $profile->user_id = $user_id;
		// $profile->save();
		// $sk = new StreamingKey;
		// $sk->user_id = $user_id;
		// $sk->save();
		return Redirect::to('/register/profile')
		->with('flash_message', 'Please Register First');

		// if the above doesn't work some bad happened.  die and dump
		dd('try again');

	}
	// if not ask for permission first
	else {
		// get fb authorization
		$url = $fb->getAuthorizationUri();

		// return to facebook login url
		 return Redirect::to( (string)$url );
	}
}

public function loginWithTwitter() {

	$token = Input::get( 'oauth_token' );
	$verify = Input::get( 'oauth_verifier' );
	$tw = OAuth::consumer( 'Twitter' );
	if ( !empty( $token ) && !empty( $verify ) )
	{
		$token = $tw->requestAccessToken( $token, $verify );
		$result = json_decode( $tw->request( 'account/verify_credentials.json' ), true );
		$answer = 0;
		$unique_checker = DB::select('select * from users where provider_uid = '. $result['id'] );
		foreach ($unique_checker as $finder)
		{
			$answer = $finder->provider_uid;
			$user_id = $finder->id;
		}
		if ($answer === $result['id'])
		{
			Auth::loginUsingId($user_id);
			return Redirect::home();
		}
		return Redirect::to('/register/profile')
		->with('flash_message', 'Please Register First');
		dd('try again');
	}
	else
	{
		$reqToken = $tw->requestRequestToken();
		$url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));
		return Redirect::to( (string)$url );
	}
}

public function loginWithGoogle() {

	$code = Input::get( 'code' );
	$googleService = OAuth::consumer( 'Google' );
	if ( !empty( $code ) )
	{
		// dd($result);
		$token = $googleService->requestAccessToken( $code );
		$result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );
		$answer = 0;
		$unique_checker = DB::select('select * from users where provider_uid = '. $result['id'] );
		foreach ($unique_checker as $finder)
		{
			$answer = $finder->provider_uid;
			$user_id = $finder->id;
		}
		if ($answer === $result['id'])
		{
			Auth::loginUsingId($user_id);
			return Redirect::home();
		}
		return Redirect::to('/register/profile')
		->with('flash_message', 'Please Register First');
		dd('try again');

	}
	else
	{
		$url = $googleService->getAuthorizationUri();
		return Redirect::to( (string)$url );
	}
}

public function registerWithFacebookArtist() {

	$code = Input::get( 'code' );
	$fb = OAuth::consumer( 'Facebook' );
	if ( !empty( $code ) )
	{
		$token = $fb->requestAccessToken( $code );
		$result = json_decode( $fb->request( '/me' ), true );
		$answer = 0;
		$unique_checker = DB::select('select * from users where provider_uid = '. $result['id'] );
		if(count($unique_checker) > 0)
		{
			return Redirect::home();
		}
		foreach ($unique_checker as $finder)
		{
			$answer = $finder->provider_uid;
			$user_id = $finder->id;
		}
		if ($answer === $result['id'])
		{
			Auth::loginUsingId($user_id);
			return Redirect::home();
		}
		$user = new User;
		$user->username = $result['name'];
		$user->displayname = $result['name'];
		// need valid facebook app in order to get registration email from facebook
		// $user->email = $result['email'];
		$user->provider = 'facebook';
		$user->provider_uid = $result['id'];
		$user->type = 'artist';
		$user->email = null;
		$user->password = null;
		$user->save();
		Auth::login($user);
		$user_id = $user->id;
		$profile = new Profile;
		$profile->user_id = $user_id;
		$profile->save();
		$sk = new StreamingKey;
		$sk->user_id = $user_id;
		$sk->save();
		$artist = new Artist;
		$artist->user_id = $user_id;
		$artist->name = $result['name'];
		$artist->save();
		Session::put('complete_artist_info', true);
		return Redirect::home();

		// if the above doesn't work some bad happened.  die and dump
		dd('try again');
	}
	else
	{
		$url = $fb->getAuthorizationUri();
		 return Redirect::to( (string)$url );
	}
}

public function registerWithTwitterArtist() {

	$token = Input::get( 'oauth_token' );
	$verify = Input::get( 'oauth_verifier' );
	$tw = OAuth::consumer( 'Twitter' );
	if ( !empty( $token ) && !empty( $verify ) )
	{
		$token = $tw->requestAccessToken( $token, $verify );
		$result = json_decode( $tw->request( 'account/verify_credentials.json' ), true );
		$answer = 0;
		$unique_checker = DB::select('select * from users where provider_uid = '. $result['id'] );
		if(count($unique_checker) > 0)
		{
			return Redirect::home();
		}
		foreach ($unique_checker as $finder)
		{
			$answer = $finder->provider_uid;
			$user_id = $finder->id;
		}
		if ($answer === $result['id']){
			Auth::loginUsingId($user_id);
			return Redirect::home();
		}
		$user = new User;
		$user->username = $result['screen_name'];
		$user->provider = 'twitter';
		$user->email = null;
		$user->provider_uid = $result['id'];
		$user->type = 'artist';
		$user->save();
		Auth::login($user);
		$user_id = $user->id;
		$profile = new Profile;
		$profile->user_id = $user_id;
		$profile->save();
		$sk = new StreamingKey;
		$sk->user_id = $user_id;
		$sk->save();
		$artist = new Artist;
		$artist->user_id = $user_id;
		$artist->name = $result['name'];
		$artist->save();
		Session::put('complete_artist_info', true);
		return Redirect::home();

		// if the above doesn't work some bad happened.  die and dump
		dd('try again');
	}
	else
	{
		$reqToken = $tw->requestRequestToken();
		$url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));
		return Redirect::to( (string)$url );
	}
}

public function registerWithGoogleArtist() {

	// get data from input
	$code = Input::get( 'code' );

	// get google service
	$googleService = OAuth::consumer( 'Google' );

	// check if code is valid

	// if code is provided get user data and sign in
	if ( !empty( $code ) ) {

		$token = $googleService->requestAccessToken( $code );
		$result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );
		$answer = 0;
		$email = $result['email'];
		$email_checker =  DB::table('users')
		->where('email', '=', $email)
		->count();
		if ($email_checker > 0)
		{
			return Redirect::home()->with('flash_message', 'Your Email Address Already Exists');;
		}
		$unique_checker = DB::select('select * from users where provider_uid = '. $result['id'] );
		foreach ($unique_checker as $finder)
		{
			$answer = $finder->provider_uid;
			$user_id = $finder->id;
		}
		if ($answer === $result['id'])
		{
			Auth::loginUsingId($user_id);
			return Redirect::home();
		}
		$user = new User;
		$user->username = $result['name'];
		$user->provider = 'google';
		$user->email = $email;
		$user->provider_uid = $result['id'];
		$user->type = 'artist';
		$user->save();
		Auth::login($user);
		$user_id = $user->id;
		$profile = new Profile;
		$profile->user_id = $user_id;
		$profile->save();
		$sk = new StreamingKey;
		$sk->user_id = $user_id;
		$sk->save();
		$artist = new Artist;
		$artist->user_id = $user_id;
		$artist->name = $result['name'];
		$artist->save();
		Session::put('complete_artist_info', true);
		return Redirect::home();
		dd('try again');
	}
	else
	{
		$url = $googleService->getAuthorizationUri();
		return Redirect::to( (string)$url );
	}
}

public function registerWithFacebookFan() {

	$code = Input::get( 'code' );
	$fb = OAuth::consumer( 'Facebook' );
	if ( !empty( $code ) )
	{
		$token = $fb->requestAccessToken( $code );
		$result = json_decode( $fb->request( '/me' ), true );
		$answer = 0;
		$unique_checker = DB::select('select * from users where provider_uid = '. $result['id'] );
		if(count($unique_checker) > 0)
		{
			return Redirect::home();
		}
		foreach ($unique_checker as $finder)
		{
			$answer = $finder->provider_uid;
			$user_id = $finder->id;
		}
		if ($answer === $result['id'])
		{
			Auth::loginUsingId($user_id);
			return Redirect::home();
		}
		$user = new User;
		$user->username = $result['name'];
		$user->displayname = $result['name'];
		// need valid facebook app in order to get registration email from facebook
		$user->provider = 'facebook';
		$user->provider_uid = $result['id'];
		$user->type = 'fan';
		$user->email = null;
		$user->password = null;
		$user->save();
		Auth::login($user);
		$user_id = $user->id;
		$profile = new Profile;
		$profile->user_id = $user_id;
		$profile->save();
		$sk = new StreamingKey;
		$sk->user_id = $user_id;
		$sk->save();
		return Redirect::home();

		// if the above doesn't work some bad happened.  die and dump
		dd('try again');
	}
	else
	{
		$url = $fb->getAuthorizationUri();
		 return Redirect::to( (string)$url );
	}
}

public function registerWithTwitterFan() {

	$token = Input::get( 'oauth_token' );
	$verify = Input::get( 'oauth_verifier' );
	$tw = OAuth::consumer( 'Twitter' );
	if ( !empty( $token ) && !empty( $verify ) )
	{
		$token = $tw->requestAccessToken( $token, $verify );
		$result = json_decode( $tw->request( 'account/verify_credentials.json' ), true );
		$answer = 0;
		$unique_checker = DB::select('select * from users where provider_uid = '. $result['id'] );
		if(count($unique_checker) > 0)
		{
			return Redirect::home();
		}
		foreach ($unique_checker as $finder)
		{
			$answer = $finder->provider_uid;
			$user_id = $finder->id;
		}
		if ($answer === $result['id']){
			Auth::loginUsingId($user_id);
			return Redirect::home();
		}
		$user = new User;
		$user->username = $result['screen_name'];

		$user->provider = 'twitter';
		$user->provider_uid = $result['id'];
		$user->type = 'fan';
		$user->email = null;
		$user->save();
		Auth::login($user);
		$user_id = $user->id;
		$profile = new Profile;
		$profile->user_id = $user_id;
		$profile->save();
		$sk = new StreamingKey;
		$sk->user_id = $user_id;
		$sk->save();
		return Redirect::home();

		// if the above doesn't work some bad happened.  die and dump
		dd('try again');
	}
	else
	{
		$reqToken = $tw->requestRequestToken();
		$url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));
		return Redirect::to( (string)$url );
	}
}

public function registerWithGoogleFan() {

	// get data from input
	$code = Input::get( 'code' );

	// get google service
	$googleService = OAuth::consumer( 'Google' );

	// check if code is valid

	// if code is provided get user data and sign in
	if ( !empty( $code ) ) {

		$token = $googleService->requestAccessToken( $code );
		$result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );
		$answer = 0;
		$email = $result['email'];
		$email_checker =  DB::table('users')
		->where('email', '=', $email)
		->count();
		if ($email_checker > 0)
		{
			return Redirect::home()->with('flash_message', 'Your Email Address Already Exists');;
		}
		$unique_checker = DB::select('select * from users where provider_uid = '. $result['id'] );
		foreach ($unique_checker as $finder)
		{
			$answer = $finder->provider_uid;
			$user_id = $finder->id;
		}
		if ($answer === $result['id'])
		{
			Auth::loginUsingId($user_id);
			return Redirect::home();
		}
		$user = new User;
		$user->username = $result['name'];
		$user->provider = 'google';
		$user->email = $email;
		$user->provider_uid = $result['id'];
		$user->type = 'fan';
		$user->save();
		Auth::login($user);
		$user_id = $user->id;
		$profile = new Profile;
		$profile->user_id = $user_id;
		$profile->save();
		$sk = new StreamingKey;
		$sk->user_id = $user_id;
		$sk->save();
		return Redirect::home();
		dd('try again');
	}
	else
	{
		$url = $googleService->getAuthorizationUri();
		return Redirect::to( (string)$url );
	}
}

}