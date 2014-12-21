<?php

namespace Earbuzz\Composers;

use DB, Auth;

class PostComposer {

	// Global view composer when posts.index is called (see 'start/global.php')
	public function compose($view)
	{
		if (Auth::check())
		{
			$favorites = DB::table('favorites')->whereUserId(Auth::user()->id)->lists('artist_id');

			$view->with('favorites', $favorites);
		}
	}

}