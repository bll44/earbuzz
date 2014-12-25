<?php

class StoreController extends \BaseController {

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

	public function showArtistMusic($id)
	{
		$artist = Artist::find($id);

		$albums = $artist->albums;

		$music = new StdClass;
		$music->albums = new StdClass;
		foreach($albums as $album)
		{
			$music->albums->{$album->name} = array('album' => $album, 'tracks' => []);
			foreach($album->tracks as $track)
			{
				$music->albums->{$album->name}['tracks'][] = $track;
			}
		}

		return View::make('store.show_artist', compact('music', 'artist'));
	}

	public function purchaseTrack($id)
	{
		return Track::download($id);
	}

	public function purchaseAlbum($id)
	{
		return Album::download($id);
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
