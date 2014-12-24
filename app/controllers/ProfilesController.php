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
		try
		{
			$user = User::with('profile')->whereUsername($username)->firstOrFail();
		}
		catch(ModelNotFoundException $e)
		{
			return Redirect::home();
		}

		if($user->type === 'artist')
		{
			$artist = $user->artist;
		}

		$artist = $user->artist;
		$favorites = DB::table('favorites')->whereUserId(Auth::user()->id)->lists('artist_id');

		// return View::make('profiles.show', ['user' => $user, 'music' => $music]);
		return View::make('profiles.show', compact('user', 'music', 'artist', 'favorites'));
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