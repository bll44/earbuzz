<?php

class Artist extends Eloquent {

	protected $table = 'artists';

	public function albums()
	{
		return $this->hasMany('Album');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function genre()
	{
		return $this->belongsTo('Genre');
	}

}