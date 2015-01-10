<?php

class MediaController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	public function showRecentStreams()
	{
		if(Auth::user()->streamingKey == null)
		{
			return Redirect::route('account.show')->with('message', 'You must generate your streaming key before you can view your recent streams.');
		}
		$streaming_key = Auth::user()->streamingKey->key;
		$dirPath = Config::get('constants.COMPLETED_STREAMS_BUCKET') . '/' . $streaming_key;
		$streamFiles = array();
		$files = array();
		if(File::exists($dirPath))
		{
			foreach(File::files($dirPath) as $file)
			{
				$files[] = new SplFileInfo($file);
			}
		}

		return View::make('recent_streams.index', ['files' => $files]);
	}


	/**
	 * Show the video editor for clipping a past stream by the artist
	 *
	 * @param  string $filename
	 * @return Response
	 */
	public function edit($filename)
	{
		return View::make('recent_streams.edit', ['filename' => $filename]);
	}

	public function processAndClipVideo()
	{
		// sets page timeout to unlimited
		set_time_limit(0);
		ignore_user_abort(1);

		// define ffmpeg & ffprobe binaries
		$ffmpeg_binary = '/ffmpeg/bin/ffmpeg.exe';
		$ffprobe_binary = '/ffmpeg/bin/ffprobe.exe';

		$filename = Input::get('file_name');
		$tracks = Input::get('track_listing');
		$album_name = Input::get('album_name');
		$streaming_key = Auth::user()->streamingKey->key;
		$artist_id = Auth::user()->artist->id;
		$album = Album::where('artist_id', $artist_id)->where('name', $album_name)->first();

		$source_dir = Config::get('constants.COMPLETED_STREAMS_BUCKET') . '/' . $streaming_key;

		// create individual artist directory
		if( ! File::isDirectory($destination_dir = Config::get('constants.TRANSCODER_FIRST_PASS') . '/' . $artist_id))
		{
			File::makeDirectory($destination_dir);
			File::makeDirectory($destination_dir . '/clips');
		}

		// .mp4 to .mp3 conversion ffmpeg command string
		$cmd = "{$ffmpeg_binary} -i \"{$source_dir}/{$filename}\" -ab 320k \"{$destination_dir}/{$streaming_key}.mp3\" 2>&1";
		$output = shell_exec($cmd);

		$track_destination_directory = Config::get('constants.MUSIC_STORAGE_BUCKET') . '/' . $artist_id . '/' . $album_name;
		if(count($tracks) > 0)
		{
			foreach($tracks as $t)
			{
				$t = (object) $t;
				$track = new Track;
				$track->name = $t->name;
				$track->album_id = $album->id;
				$track->duration = round($t->duration, 0, PHP_ROUND_HALF_UP);
				$track->price = 0.99;
				$cmd = "{$ffmpeg_binary} -i \"{$destination_dir}/{$streaming_key}.mp3\" -ab 320k -ss {$t->start_time} -t {$t->duration} \"{$track_destination_directory}/{$t->name}.mp3\" 2>&1";
				$output = shell_exec($cmd);
				$track->save();
			}
		}

		if(File::deleteDirectory($destination_dir))
			return json_encode(['status' => 'success']);
		else
			return json_decode(['status' => 'error', 'message' => 'Could not delete file in audio edits. Please contact site administrator to get this resolved immediately.']);
	}

	public function nameAlbum()
	{
		$date = new DateTime();
		$artist_id = Auth::user()->artist->id;
		$album_name = Input::get('album_name');
		$album_genre = Input::get('album_genre');

		$album = new Album;
		$album->name = $album_name;
		$album->year = $date->format('Y');
		$album->genre = $album_genre;
		$album->price = 9.99;
		$album->artist_id = $artist_id;

		if( ! File::isDirectory($artist_dir = Config::get('constants.MUSIC_STORAGE_BUCKET') . '/' . $artist_id))
		{
			File::makeDirectory($artist_dir);
		}
		if( ! File::isDirectory($album_dir = $artist_dir . '/' . $album_name))
		{
			File::makeDirectory($album_dir);
			$album->save();
			return json_encode(['status' => 'success', 'message' => 'Album directory successfully created']);
		}
		else
		{
			return json_encode(['status' => 'error', 'message' => 'Album name is already taken by one of your other albums. Please use a different name']);
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
