<?php

class Album extends Eloquent {

	protected $table = 'albums';

	public function tracks()
	{
		return $this->hasMany('Track');
	}

	public function artist()
	{
		return $this->belongsTo('Artist');
	}

	public static function download($id)
	{

	}

}