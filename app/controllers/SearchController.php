<?php

/**
 * SearchController is used for the "smart" search throughout the site.
 * it returns and array of items (with type and icon specified) so that the selectize.js plugin can render the search results properly
 **/

class SearchController extends BaseController {

	public function messageTo($username)
	{
		$data = array();

		$id = Auth::user()->getId();

		$results = User::select('username')
			->where('id', "!=", $id)
			->where('username', 'LIKE',$username . '%')
			->take(5)
			->get();

		// foreach ($results as $result):
		// 	$data[] = $result->username."";
		// endforeach;

		return $results;
		// return $results->toJson();
		// return $results->toArray();
		// return Response::json($data);
	}

	public function listUsernames()
	{

		$id = Auth::user()->getId();

		$results = User::select('username', 'id')
			->where('id', "!=", $id)
			->get();

		return $results;
	}

}