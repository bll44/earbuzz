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
		// this is only temporary to stop it from erroring if no user is logged in when trying to view a profile
		if(Auth::guest()) return Redirect::home();

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
			$next_concert = $next_concert[0];
		}
		else
		{
			$next_concert = null;
		}
		
		// return View::make('profiles.show', ['user' => $user, 'music' => $music]);
		return View::make('profiles.show', compact('user', 'music', 'artist', 'favorites', 'countdown', 'upcoming', 'next_concert', 'is_artist_profile'));
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
		return Input::all();

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