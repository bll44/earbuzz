<?php

class Genre extends Eloquent {

	protected $table = 'genres';

	public $timestamps = false;

	public function artists()
	{
		return $this->belongsToMany('Artist');
	}

}