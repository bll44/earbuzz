<?php

class PagesController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$concerts = Concert::with('Artist')->orderBy('start_time', 'ASC')->paginate(4);
		$mcids = array();
		if(Auth::check())
		{
			$my_concerts = Auth::user()->concerts;
			foreach($my_concerts as $mc)
			{
				$mcids[] = $mc->id;
			}
		}
		return View::make('pages.index', compact('concerts', 'mcids'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function home()
	{
		return View::make('home');
	}

	/**
	 * Show styleguide resource page
	 *
	 * @return Response
	 */
	public function styleguide()
	{
		return View::make('pages.styleguide', array('bodyClass' => 'vStyle'));
	}

}
