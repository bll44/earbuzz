<?php

class PagesController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$concerts = Concert::with('Artist')->orderBy('start_time', 'ASC')->take(5)->get();
		return View::make('pages.index', compact('concerts'));
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