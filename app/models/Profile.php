<?php

class Profile extends Eloquent {

	/**
	 * Fillable fields.
	 *
	 * @var array
	 */
	protected $fillable = [
	'location', 'bio', 'twitter_username', 'lastfm_username', 'facebook_username'
	];

	public function user()
	{
		return $this->belongsTo('User');
	}

}