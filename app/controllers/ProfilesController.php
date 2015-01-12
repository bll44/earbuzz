<?php

use Earbuzz\Forms\ProfileForm;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProfilesController extends BaseController {

	/**
	 * @var ProfileForm
	 */
	private $profileForm;

	function __construct(ProfileForm $profileForm)
	{
		$this->profileForm = $profileForm;

		$this->beforeFilter('currentUser', ['only' => ['edit', 'update']]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($username)
	{
		if ( ! Auth::guest())
		{
			// THIS ALL NEEDS MOVED TO A CONTROLLER!

			$config = array(
				'KEY' => '999a6964f87015288a65',
				'SECRET' => 'ee1d6acc6f9f8dfdf94c',
				'APPID' => '80855'
			);

			$pusher = new Pusher($config['KEY'], $config['SECRET'], $config['APPID']);

			if( ! empty($_POST)
				&& array_key_exists('channel', $_POST)
				&& array_key_exists('user', $_POST)
				&& array_key_exists('content', $_POST)
			)
			{
				$pusher->trigger($_POST['channel'], 'message-created', array(
					'user' => $_POST['user'],
					'content' => $_POST['content']
				));
			}
		}

		try
		{
			$user = User::with('profile')->whereUsername($username)->firstOrFail();
		}
		catch(ModelNotFoundException $e)
		{
			return Redirect::home();
		}

		$is_artist_profile = false;
		if($user->type === 'artist')
		{
			$artist = $user->artist;
			$is_artist_profile = true;
		}

		$artist = $user->artist;
		$favorites = array();
		$next_concert = null;
		if(Auth::check())
		{
			$favorites = DB::table('favorites')->whereUserId(Auth::user()->id)->lists('artist_id');
		}
		// check for currently ongoing concerts by this artist
		$current = DB::select("SELECT * FROM concerts WHERE artist_id = '{$artist->id}' AND start_time < CURRENT_TIMESTAMP AND end_time > CURRENT_TIMESTAMP ORDER BY start_time ASC");
		count($current) > 0 ? $countdown = false : $countdown = true;

		// get all upcoming concerts
		$upcoming = DB::select("SELECT * FROM concerts WHERE artist_id = '{$artist->id}' AND start_time > CURRENT_TIMESTAMP ORDER BY start_time ASC");
		if($user->type === 'artist')
		{
			$next_concert = DB::select("SELECT * FROM concerts WHERE artist_id = '{$artist->id}' AND start_time > CURRENT_TIMESTAMP ORDER BY start_time ASC LIMIT 1");
			if(count($next_concert) > 0) $next_concert = $next_concert[0];
		}
		count($next_concert) > 0 ?: $next_concert = null;

		return View::make('profiles.show',
			compact(
				'user',
				'music',
				'artist',
				'favorites',
				'countdown',
				'upcoming',
				'next_concert',
				'is_artist_profile'
			)
		);
	}

	// Display specific users favorites
	public function favorites($username)
	{
		$genres = Genre::all();

		try
		{
			$artists = User::with('profile')->whereUsername($username)->firstOrFail()->favorites;
		}
		catch(ModelNotFoundException $e)
		{
			return Redirect::home();
		}

		return View::make('posts.index', compact('artists', 'genres'));
	}

	// Broadcaster dashboard
	public function dashboard($username)
	{
		$user = User::whereUsername($username)->firstOrFail();

		return View::make('profiles.dashboard')
		->withUser($user);
	}


	public function edit($username)
	{
		$user = User::whereUsername($username)->firstOrFail();

		return View::make('profiles.edit')
		->withUser($user);
	}

	public function update($username)
	{

		$user = User::whereUsername($username)->firstOrFail();

		$input = Input::only('location', 'bio', 'twitter_username', 'lastfm_username', 'facebook_username');

		$this->profileForm->validate($input);

		$user->profile->fill($input)->save();

		return Redirect::route('profile.edit', $user->username);
	}

	public function editArtistProfile($id)
	{
		$user = User::find($id);
		$profile = $user->profile;
		$artist = $user->artist;
		$genres = Genre::all();
		$genre_select = array();
		foreach($genres as $g)
		{
			$genre_select[$g->id] = ucwords($g->name);
		}

		return View::make('profiles.edit_artist',
			[
				'profile' => $profile,
				'artist' => $artist,
				'user' => $user,
				'genres' => $genres,
				'genre_select' => $genre_select,
			]
		);
	}

	public function updateArtist($id)
	{
		$user = User::find($id);
		$profile = $user->profile;
		$artist = $user->artist;

		$input = (object) Input::all();

		# user info
		$user->displayname = $input->band_name;

		# profile info
		$profile->display_name = $input->band_name;
		$profile->location = $input->location;
		$profile->bio = $input->bio;

		#artist info
		$artist->name = $input->band_name;
		$artist->genre_id = $input->genre;

		$user->save();
		$profile->save();
		$artist->save();

		return Redirect::route('profile.show', [$user->username]);
	}

}