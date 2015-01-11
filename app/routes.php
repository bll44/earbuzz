<?php
App::bind('Earbuzz\Billing\BillingInterface', 'eEarbuzz\Billing\StripeBilling');

Route::get('testing', function()
{
	return User::find(2)->concerts;
});

Route::group(['before' => 'auth'], function()
{
	Route::get('recent_streams', ['as' => 'recent_streams.show', 'uses' => 'MediaController@showRecentStreams']);
	Route::get('recent_streams/edit/{file_name}', ['as' => 'recent_streams.edit', 'uses' => 'MediaController@edit']);
	Route::post('recent_streams/process', ['as' => 'recent_streams.process', 'uses' => 'MediaController@processAndClipVideo']);
	Route::get('recent_streams/get_job_progress', ['as' => 'recent_streams.get_job_progress', 'uses' => 'MediaController@getJobProgress']);
	Route::post('recent_streams/name_album', ['as' => 'recent_streams.name_album', 'uses' => 'MediaController@nameAlbum']);

	// artist status change route
	Route::post('artist/status/change', ['as' => 'status.change', 'uses' => 'ArtistsController@changeStatus']);

	// add user to guest list for concert
	Route::post('concert/attend', ['as' => 'concert.attend', 'uses' => 'ConcertController@addGuest']);
});

Route::get('upcoming_shows', 'ConcertController@index');

# Billing - Stripe
Route::get('buy', ['as' => 'upgrade', 'uses' => 'BillingController@buy']);
Route::post('buy', ['as' => 'upgrade.buy', 'uses' => 'BillingController@premium_buy']);
Route::get('cancel', ['as' => 'cancel.subcription', 'uses' => 'BillingController@cancel']);
Route::get('resume', ['as' => 'resume', 'uses' => 'BillingController@resume']);
Route::post('resume', ['as' => 'resume.buy', 'uses' => 'BillingController@resume_buy']);
Route::post('stripe/webhook', 'Laravel\Cashier\WebhookController@handleWebhook');
Route::get('stripe/is_customer', ['as' => 'stripe.is_customer', 'uses' => 'BillingController@checkCustomerStatus']);

# Stripe Route Filter for Premium Only Access Pages
Route::filter('subscribed', function()
{
	if (Auth::user() && ! Auth::user()->subscribed())
	{
		return Redirect::to('billing');
	}
});

# Unused Stripe
// $billing = App::make('Earbuzz\Billing\BillingInterface');

Route::post('stripetest', function()
{
	try
	{
		// $customerId = $billing->charge([
			// 'email' => Input::get('email'),
			// 'token' => Input::get('stripe-token')
		// ]);
		// dd($customerId);
		// $user = Auth::id();
		// $user->billing_id = $customerId;
		// $user->save();
	}
	catch(Exception $e)
	{
		return Redirect::refresh()->withFlashMessage($e->getMessage());
	}
	return 'Charge was successful';

	// return $billing->charge([
		// 'email' => Input::get('email'),
		// 'token' => Input::get('stripe-token')
		// ]);
});

# Testing // Cache
Route::filter('cache.fetch', 'Music\Filters\CacheFilter@fetch');
Route::filter('cache.put', 'Music\Filters\CacheFilter@put');

Route::Get('last', function()
{
	return View::make('pages.index');
	// Cache::put('foo', 'bar', 10);
	// if (Cache::has('foo')) return Cache::get('foo', 'default value');
	// return Cache::get('foo', 'default value');
})->before('cache.fetch')->after('cache.put');

// editing/deleting/updating an artist's album.
Route::get('files/music/{album_id}/name-change/{new_album_name}', ['as' => 'album.change-name', 'uses' => 'MusicFilesController@']);
Route::get('files/music/manager/{artist_id}', 'MusicFilesController@show');

// Music Uploading
Route::resource('uploads/music', 'MusicUploadController');

Route::resource('artists', 'ArtistsController');

# StyleGuide
Route::get('styleguide', ['as' => 'styleguide', 'uses' => 'PagesController@styleguide']);

# Favorites
## Browse all aritsts - add as favorites
Route::get('browse', ['as' => 'browse', 'uses' => 'SearchController@browse']);

## Add to Favorites
Route::post('favorites', ['as' => 'favorites.store', function()
{
	Auth::user()->favorites()->attach(Input::get('post-id'));

	return Redirect::back();
}])->before('auth|csrf');

## Delete from Favorites
Route::delete('favorites/{postId}', ['as' => 'favorites.destroy', function($postId)
{
	Auth::user()->favorites()->detach($postId);

	return Redirect::back();
}])->before('auth|csrf');

# Homepage
Route::get('/', ['as' => 'home', 'uses' => 'PagesController@index']);

# Registration
Route::get('/register/profile', ['as' => 'register', 'uses' => 'RegistrationController@profileSelection'])->before('guest');
Route::get('/register/fan', ['as' => 'register.fan', 'uses' => 'RegistrationController@createFan'])->before('guest');
Route::get('/register/artist', ['as' => 'register.artist', 'uses' => 'RegistrationController@createArtist'])->before('guest');
// Route::post('/register', ['as' => 'registration.store', 'uses' => 'RegistrationController@store']);
Route::post('/register/fan', ['as' => 'registration.store_fan', 'uses' => 'RegistrationController@store_fan']);
Route::post('/register/artist', ['as' => 'registration.store_artist', 'uses' => 'RegistrationController@store_artist']);
Route::get('/login/facebook', ['as' => 'registration.loginWithFacebook', 'uses' => 'RegistrationController@loginWithFacebook']);
Route::get('/login/twitter', ['as' => 'registration.loginWithTwitter', 'uses' => 'RegistrationController@loginWithTwitter']);
Route::get('/login/google', ['as' => 'registration.loginWithGoogle', 'uses' => 'RegistrationController@loginWithGoogle']);
Route::get('/register/artist/facebook', ['as' => 'registration.registerWithFacebookArtist', 'uses' => 'RegistrationController@registerWithFacebookArtist']);
Route::get('/register/artist/twitter', ['as' => 'registration.registerWithTwitterArtist', 'uses' => 'RegistrationController@registerWithTwitterArtist']);
Route::get('/register/artist/google', ['as' => 'registration.registerWithGoogleArtist', 'uses' => 'RegistrationController@registerWithGoogleArtist']);
Route::get('/register/fan/facebook', ['as' => 'registration.registerWithFacebookFan', 'uses' => 'RegistrationController@registerWithFacebookFan']);
Route::get('/register/fan/twitter', ['as' => 'registration.registerWithTwitterFan', 'uses' => 'RegistrationController@registerWithTwitterFan']);
Route::get('/register/fan/google', ['as' => 'registration.registerWithGoogleFan', 'uses' => 'RegistrationController@registerWithGoogleFan']);

# Messages
Route::group(['prefix' => 'messages'], function () {
	Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
	Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
	Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
	Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
	Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
});

# Pusher
App::singleton('Pusher', function($app) {
	$keys = $app['config']->get('services.pusher');
	return new Pusher(
		$keys['public'],
		$keys['secret'],
		$keys['app_id']
		);
	});

# Chat
Route::get('chat', ['as' => 'get.chat', 'uses' => 'MessagesController@chat']);
Route::post('chat', ['as' => 'post.chat', 'uses' => 'MessagesController@chat']);

Route::any('tester', function()
{
	App::make('Pusher')->trigger(
		'demo',
		'PostWasPublished',
		['title' => 'Concert Notification']
	);
	// Do Whataver
	return 'Done';
});

# Search
Route::get('api/search', 'SearchController@listUsernames');
Route::get('api/search/{username}', 'SearchController@messageTo');

# Live (Streams)
Route::resource('live', 'LiveController');

# Authentication - Default
Route::get('login', ['as' => 'login', 'uses' => 'SessionsController@create']);
Route::get('logout', ['as' => 'logout', 'uses' => 'SessionsController@destroy']);
Route::resource('sessions', 'SessionsController', ['only' => ['create', 'store', 'destroy']]);

# Authentication - HybridAuth
// Route::get('/social/{provider}/{action?}', array("as" => "loginWith", "uses" => "SessionsController@loginWithSocial"));

# Account
Route::get('/stream/resetStreamKey', 'AccountsController@resetStreamKey');
Route::get('/stream/generateStreamKey', 'AccountsController@generateStreamKey');
Route::resource('account', 'AccountsController');

# Profile
Route::resource('profile', 'ProfilesController', ['only' => ['show', 'edit', 'update']]);
Route::get('profile/{profile}', ['as' => 'profile', 'uses' => 'ProfilesController@show']);
Route::get('profile/{profile}/favorites', ['as' => 'profile.favorites', 'uses' => 'ProfilesController@favorites']);
// Route::get('/{profile}/dashboard', ['as' => 'profile.dashboard', 'uses' => 'ProfilesController@dashboard']);

# Artist profile edit
Route::get('artist/{profile}/edit', ['as' => 'profile.edit_artist', 'uses' => 'ProfilesController@editArtistProfile']);

# Artist profile update
Route::post('artist/{profile}/update', ['as' => 'profile.update_artist', 'uses' => 'ProfilesController@updateArtist']);

# Concert routes
Route::resource('concert', 'ConcertController');
Route::get('concert/{concert}/cancel', ['as' => 'concert.cancel', 'uses' => 'ConcertController@cancel']);
Route::get('concert/details/get', 'ConcertController@getConcertDetails');
// Route::get('post/concert/notification', 'ConcertController@postNotification');

Route::get('store/{artist}/music', ['as' => 'store.artist.music', 'uses' => 'StoreController@showArtistMusic']);

// Route::get('store/purchase/track/{track}', ['as' => 'store.track.purchase', 'uses' => 'StoreController@purchaseTrack']);
// Route::get('store/purchase/album/{album}', ['as' => 'store.album.purchase', 'uses' => 'StoreController@purchaseAlbum']);
Route::post('store/charge/music', ['as' => 'store.music.charge', 'uses' => 'StoreController@chargeMusic']);
Route::get('store/purchase/complete', ['as' => 'purchase.complete_and_download', 'uses' => 'StoreController@completeAndDownloadPurchase']);
Route::get('download/track', ['as' => 'download.track', 'uses' => 'StoreController@downloadTrack']);
Route::get('download/album', ['as' => 'download.album', 'uses' => 'StoreController@downloadAlbum']);

# Password Reminder
Route::controller('password', 'RemindersController');
// Route::get('password/remind', ['as' => 'password.remind', 'uses' => 'RemindersController@getRemind']);
// Route::post('password/remind', 'RemindersController@postRemind');
// Route::get('password/reset/{token}', 'RemindersController@getReset');
// Route::post('password/reset/{token}', 'RemindersController@postReset');

# Dashboard
// Route::get('/home', ['as' => 'home', 'uses' => 'PagesController@home']);

# Authentication Check
// Route::group(array('before' => 'auth'), function()
// {
// });
