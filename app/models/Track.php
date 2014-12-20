<?php

class Track extends Eloquent {

	protected $table = 'tracks';

	public function album()
	{
		return $this->belongsTo('Album');
	}

}