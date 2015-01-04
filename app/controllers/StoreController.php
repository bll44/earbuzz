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

	public function downloadTrack()
	{
		$id = Session::get('purchase_download_id');
		Session::forget('purchase_download_id');
		return Track::download($id);
	}

	public function downloadAlbum()
	{
		$id = Session::get('purchase_download_id');
		Session::forget('purchase_download_id');
		return Album::download($id);
	}

	public function chargeMusic()
	{
		App::bind('Earbuzz\Billing\BillingInterface', 'Earbuzz\Billing\StripeBilling');
		$billing = App::make('Earbuzz\Billing\BillingInterface');

		$package_type = Input::get('package-type');
		$package_id = Input::get('package-id');
		if($package_type === 'track')
		{
			$track_id = $package_id;
			$track = Track::find($track_id);
			$item = $track;
			$album = $track->album;
			$artist = $album->artist;
			$amount = $track->price;
			$type = 'track';
			$charge_description = "Purchase Details: Track: '{$track->name}' / Album - '{$album->name}' / Artist - '{$artist->name}'";
		}
		elseif($package_type === 'album')
		{
			$album_id = $package_id;
			$album = Album::find($album_id);
			$item = $album;
			$artist = $album->artist;
			$amount = $album->price;
			$type = 'album';
			$charge_description = "Purchase Details: Album - '{$album->name}' / Artist - '{$artist->name}'";
		}
		$email = Input::get('email');
		$charge = $billing->charge([
			'description' => $charge_description,
			'email' => $email,
			'amount' => $amount,
			'token' => Input::get('stripe-token')
		]);

		Session::put('purchase_download_id', $package_id);

		if($charge->paid)
			return Redirect::route('purchase.complete_and_download')->with(['package' => ['type' => $type, 'item' => $item]]);
	}

	public function completeAndDownloadPurchase()
	{
		$package = Session::get('package');
		return View::make('store.purchase_complete', compact('package'));
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
