<?php

class ConcertController extends \BaseController {

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
		$user = Auth::user();
		$artist = $user->artist;

		$concerts = Concert::where('artist_id', $artist->id)->get();

		return View::make('concerts.create', ['artist' => $artist, 'user' => $user, 'concerts' => $concerts]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = (object) Input::all();

		$concert = new Concert;

		$start_time = new DateTime($input->start_time);
		$concert->start_time = $start_time;
		$concert->end_time = Concert::duration($start_time, $input->duration);
		$concert->artist_id = Auth::user()->artist->id;
		$concert->description = strlen($input->description) > 0 ? $input->description : null;

		$concert->save();

		return Redirect::route('concert.create');
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
		return 'test ' . $id;
	}


}
