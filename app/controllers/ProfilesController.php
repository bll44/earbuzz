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

		if($user->type === 'artist') $artist = $user->artist;

		$music = new StdClass;
		if(File::exists($artist_music_bucket = Config::get('constants.MUSIC_STORAGE_BUCKET') . '/' . 4))
		{
			$album_dirs = File::directories($artist_music_bucket);
			$delimiters = array('/', '\\');
			$music = new StdClass;
			foreach($album_dirs as $ad)
			{
				$prepared = str_replace($delimiters, $delimiters[0], $ad);
				$chopped = explode($delimiters[0], $prepared);
				$music->albums = array($chopped[count($chopped) - 1] => ['tracks' => []]);
			}
			foreach($music->albums as $key => &$val)
			{
				$tracks = File::files($artist_music_bucket . '/' . $key);
				foreach($tracks as $t)
				{
					$parts = explode('/', $t);
					$trackname = $parts[count($parts) - 1];
					$p = strrpos($trackname, '.');
					$trackname = substr($trackname, 0, $p);
					$track = new Track;
					$track->name = $trackname;
					$val['tracks'][] = $track;
				}
			}
		}

		$artist = $user->artist;
		$favorites = DB::table('favorites')->whereUserId(Auth::user()->id)->lists('artist_id');

		// return View::make('profiles.show', ['user' => $user, 'music' => $music]);
		return View::make('profiles.show', compact('user', 'music', 'artist', 'favorites'));
	}

	// Display specific users favorites
	public function favorites($username)
	{
		try
		{
			$artists = User::with('profile')->whereUsername($username)->firstOrFail()->favorites;
		}
		catch(ModelNotFoundException $e)
		{
			return Redirect::home();
		}

		return View::make('posts.index', compact('artists'));
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

}