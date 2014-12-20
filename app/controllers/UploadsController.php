<?php

class UploadsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /posts
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /posts/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('uploads.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /posts
	 *
	 * @return Response
	 */
	public function store()
	{
		$upload = new Upload;
		$upload->title = Input::get('title');
		$upload->body = Input::get('body');
		if (Input::hasFile('thumbnail'))
		{
			$file = Input::file('thumbnail');

			// return [
			// 	'path' => $file->getRealPath(),
			// 	'size' => $file->getSize(),
			// 	'mime' => $file->getMimeType(),
			// 	'name' => $file->getClientOriginalName(),
			// ];

			$name = time() . '-' . $file->getClientOriginalName();

			$file = $file->move(public_path() . '/img/upload/', $name);

			$upload->thumbnail = $name; 
		}

		$upload->save();

		return View::make('uploads.view')
		->with('name', $name);
	}

	/**
	 * Display the specified resource.
	 * GET /posts/{id}
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
	 * GET /posts/{id}/edit
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
	 * PUT /posts/{id}
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
	 * DELETE /posts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}