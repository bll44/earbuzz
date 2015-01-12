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

		// get the current date
		$date = new DateTime();

		// make the current year and the next year available for scheduling
		$years = array();
		$years[] = (int) $date->format('Y'); // cast date 'year' string to an integer
		$years[] = $years[0] + 1;

		$current_month = (int) $date->format('n');
		$current_day = (int) $date->format('j');

		// return View::make('concerts.create',
		// 	[
		// 		'artist' => $artist,
		// 		'user' => $user,
		// 		'concerts' => $concerts,
		// 		'years' => $years,
		// 		'current_month' => $current_month,
		// 		'day_num' => $
		// 	]
		// );

		return View::make('concerts.create', compact('artist', 'user', 'concerts', 'years', 'current_month', 'current_day'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = (object) Input::all();

		$start_time = new DateTime();
		$date_string = $input->year . '-' . $input->month . '-' . $input->day . ' ' . $input->time.':00' . $input->ampm;
		$start_time->setTimestamp(strtotime($date_string));

		$concert = new Concert;
		$concert->start_time = $start_time->format('Y-m-d H:i:s');
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
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * Usable by BOTH standard href links and forms alike
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function cancel($id)
	{
		$concert = Concert::find($id);
		$start_time = $concert->start_time;

		$concert->delete();

		return Redirect::route('concert.create')->with('destroy_message', 'Concert scheduled for ' . $start_time . ' successfully canceled.');
	}

	public function getConcertDetails()
	{
		$concert_id = Input::get('concert_id');

		$concert = Concert::find($concert_id);
		$concert->name = Artist::find($concert->artist_id)->name;

		$date = new DateTime();
		$date->setTimestamp(strtotime($concert->start_time));
		$concert->year = (int) $date->format('Y');
		$concert->month = (int) $date->format('n');
		$concert->day = (int) $date->format('j');
		$concert->hours = (int) $date->format('h');
		$concert->minutes = (int) $date->format('i');
		$concert->ampm = $date->format('a');

		$concert->duration = ((int) strtotime($concert->end_time) - (int) strtotime($concert->start_time)) / 60 / 60;

		return json_encode($concert);
	}

	public function postNotification()
	{

	}


	public function addGuest()
	{
		$user = Auth::user();
		$concert = Concert::find(Input::get('concert'));
		$concert->guests()->attach($user->id);

		return json_encode(['success' => true]);
	}

	public function notify()
	{
		$concert = Concert::find(Input::get('concert'));

		App::make('Pusher')->trigger(
			'demo',
			'PostWasPublished',
			['title' => 'Concert Notification']
		);
		// Do Whataver
		return 'Done';
	}

}
