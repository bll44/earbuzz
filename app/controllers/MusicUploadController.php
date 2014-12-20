<?php

class MusicUploadController extends \BaseController {

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
		return View::make('uploads.music.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(Input::hasFile('tracks'))
		{
			$tracks = Input::file('tracks');
		}
		else
		{
			return Redirect::route('uploads.music.create')
				->with('form_error', 'You must upload at least 1 track.')
				->withInput();
		}

		if( ! validate_file_extensions($tracks, 'mp3'))
		{
			return Redirect::route('uploads.music.create')
				->with('track_error', 'Invalid track file format. Tracks must be in <b>.mp3</b> audio format.')
				->withInput();
		}

		// most of the artist logic will be changed to
		// accommodate a currently logged in artist.
		$artist = new Artist;
		$album = new Album;
		$artist->name = Input::get('artist'); // this will be changed to logged in artist's name.
		$album->name = Input::get('album');
		$album->artist_id = 1; // changed to currently logged in artist's id.
		$album->year = Input::get('year');

		if($album->save())
		{
			for($i = 0; $i < count($tracks); $i++)
			{
				$n = $i + 1;
				$track = new Track;
				$track->number = $n;
				$track->name = Input::get("track{$n}_name");
				$track->artist_name = $artist->name;
				$track->artist_id = 1; // see above for changes
				$track->album = $album->name;
				$track->album_id = $album->id;
				$track->year = $album->year;

				$track->save();

				$track->file = $tracks[$i];
				$track->store();
			}
		}

		return View::make('music.uploadSuccess', ['album' => $album->name]);
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


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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
