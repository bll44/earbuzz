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

		$object = new StdClass;
		$object->anyproperty = 'this';
		$object->evan = 'dumprhies';

		Auth::login($user);

		$user_id = $user->id;

	   // Create the standard user profile for the artist
		$profile = new Profile;
		$profile->user_id = $user_id;
		$profile->save();

	   // Assign a streaming key to the new artist
		$sk = new StreamingKey;
		$sk->user_id = $user_id;
		$sk->save();

	   // Create the artist profile in the database
		$artist = new Artist;
		$artist->user_id = $user_id;
		$artist->name = $input->displayname;
		$artist->save();

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

		// dd($unique_checker);

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

		// if user does not exist - create them
		$user = new User;
		$user->username = $result['name'];
		$user->displayname = $result['name'];
		$user->provider = 'facebook';
		$user->provider_uid = $result['id'];
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
	// if not ask for permission first
	else {
		// get fb authorization
		$url = $fb->getAuthorizationUri();

		// return to facebook login url
		 return Redirect::to( (string)$url );
	}
}

public function loginWithTwitter() {

	// get data from input
	$token = Input::get( 'oauth_token' );
	$verify = Input::get( 'oauth_verifier' );

	// get twitter service
	$tw = OAuth::consumer( 'Twitter' );

	// check if code is valid

	// if code is provided get user data and sign in
	if ( !empty( $token ) && !empty( $verify ) ) {

		// This was a callback request from twitter, get the token
		$token = $tw->requestAccessToken( $token, $verify );

		// Send a request with it
		$result = json_decode( $tw->request( 'account/verify_credentials.json' ), true );

		$message = 'Your unique Twitter user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
		echo $message. "<br/>";

		//Var_dump
		//display whole array().
		dd($result);

	}
	// if not ask for permission first
	else {
		// get request token
		$reqToken = $tw->requestRequestToken();

		// get Authorization Uri sending the request token
		$url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));

		// return to twitter login url
		return Redirect::to( (string)$url );
	}
}

public function loginWithGoogle() {

	// get data from input
	$code = Input::get( 'code' );

	// get google service
	$googleService = OAuth::consumer( 'Google' );

	// check if code is valid

	// if code is provided get user data and sign in
	if ( !empty( $code ) ) {

		// This was a callback request from google, get the token
		$token = $googleService->requestAccessToken( $code );

		// Send a request with it
		$result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );

		$message = 'Your unique Google user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
		echo $message. "<br/>";

		//Var_dump
		//display whole array().
		dd($result);

	}
	// if not ask for permission first
	else {
		// get googleService authorization
		$url = $googleService->getAuthorizationUri();

		// return to google login url
		return Redirect::to( (string)$url );
	}
}

public function registerWithFacebookArtist() {

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

		// dd($unique_checker);

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

		// if user does not exist - create them
		$user = new User;
		$user->username = $result['name'];
		// $user->displayname = $result['name'];
		$user->provider = 'facebook';
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
		return Redirect::home();

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

public function registerWithTwitterArtist() {

	// get data from input
	$token = Input::get( 'oauth_token' );
	$verify = Input::get( 'oauth_verifier' );

	// get twitter service
	$tw = OAuth::consumer( 'Twitter' );

	// check if code is valid

	// if code is provided get user data and sign in
	if ( !empty( $token ) && !empty( $verify ) ) {

		// This was a callback request from twitter, get the token
		$token = $tw->requestAccessToken( $token, $verify );

		// Send a request with it
		$result = json_decode( $tw->request( 'account/verify_credentials.json' ), true );

		// dd($result);
		// dd($result['id']);
		$answer = 0;

		// check database to see if unique ID exists
		$unique_checker = DB::select('select * from users where provider_uid = '. $result['id'] );

		// dd($unique_checker);

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

		// if user does not exist - create them
		$user = new User;
		$user->username = $result['name'];
		// $user->displayname = $result['name'];
		$user->provider = 'twitter';
		$user->provider_uid = $result['id'];
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
	// if not ask for permission first
	else {
		// get request token
		$reqToken = $tw->requestRequestToken();

		// get Authorization Uri sending the request token
		$url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));

		// return to twitter login url
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

		// This was a callback request from google, get the token
		$token = $googleService->requestAccessToken( $code );

		// Send a request with it
		$result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );

		$answer = 0;
		$email = $result['email'];

		// $email_checker = DB::select("select email from users where email values('$email')");
		$email_checker =  DB::table('users')
		->where('email', '=', $email)
		->count();

		if ($email_checker > 0) {
			return Redirect::home()->with('message', 'Your Email Address Already Exists');;
		}

		// check database to see if unique ID exists
		$unique_checker = DB::select('select * from users where provider_uid = '. $result['id'] );

		// dd($unique_checker);

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

		// if user does not exist - create them
		$user = new User;
		$user->username = $result['name'];
		// $user->displayname = $result['name'];
		$user->provider = 'google';
		$user->provider_uid = $result['id'];
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
	// if not ask for permission first
	else {
		// get googleService authorization
		$url = $googleService->getAuthorizationUri();

		// return to google login url
		return Redirect::to( (string)$url );
	}
}

public function registerWithFacebookFan() {

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

		// dd($unique_checker);

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

		// if user does not exist - create them
		$user = new User;
		$user->username = $result['name'];
		// $user->displayname = $result['name'];
		$user->provider = 'facebook';
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
		return Redirect::home();

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

public function registerWithTwitterFan() {

	// get data from input
	$token = Input::get( 'oauth_token' );
	$verify = Input::get( 'oauth_verifier' );

	// get twitter service
	$tw = OAuth::consumer( 'Twitter' );

	// check if code is valid

	// if code is provided get user data and sign in
	if ( !empty( $token ) && !empty( $verify ) ) {

		// This was a callback request from twitter, get the token
		$token = $tw->requestAccessToken( $token, $verify );

		// Send a request with it
		$result = json_decode( $tw->request( 'account/verify_credentials.json' ), true );

		// dd($result);
		// dd($result['id']);
		$answer = 0;

		// check database to see if unique ID exists
		$unique_checker = DB::select('select * from users where provider_uid = '. $result['id'] );

		// dd($unique_checker);

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

		// if user does not exist - create them
		$user = new User;
		$user->username = $result['name'];
		// $user->displayname = $result['name'];
		$user->provider = 'twitter';
		$user->provider_uid = $result['id'];
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
	// if not ask for permission first
	else {
		// get request token
		$reqToken = $tw->requestRequestToken();

		// get Authorization Uri sending the request token
		$url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));

		// return to twitter login url
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

		// This was a callback request from google, get the token
		$token = $googleService->requestAccessToken( $code );

		// Send a request with it
		$result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );

		$answer = 0;

		// check database to see if unique ID exists
		$unique_checker = DB::select('select * from users where provider_uid = '. $result['id'] );

		// dd($unique_checker);

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

		// if user does not exist - create them
		$user = new User;
		$user->username = $result['name'];
		// $user->displayname = $result['name'];
		$user->provider = 'twitter';
		$user->provider_uid = $result['id'];
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
	// if not ask for permission first
	else {
		// get googleService authorization
		$url = $googleService->getAuthorizationUri();

		// return to google login url
		return Redirect::to( (string)$url );
	}
}

}