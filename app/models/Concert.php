<?php

class Concert extends Eloquent {

	protected $table = 'concerts';

	public static function duration($start, $duration)
	{
	    $end = new DateTime();
	    $end_time_seconds = $start->format('U') + ($duration * 60 * 60);
	    $end->setTimestamp($end_time_seconds);
	    return $end->format('Y-m-d H:i:s');
	}

	public function getStartTimeAttribute($value)
	{
		$date = new DateTime();
		$date->setTimestamp(strtotime($value));
		return $date->format('M jS, Y h:ia');
	}

	public function getEndTimeAttribute($value)
	{
		$date = new DateTime();
		$date->setTimestamp(strtotime($value));
		return $date->format('M jS, Y h:ia');
	}

	public function artist()
	{
		return $this->belongsTo('Artist');
	}

	public function getStreamTime()
	{
		$date = new DateTime($this->start_time);
		return $date->format('g:ia');

	}

	public function getShowDate()
	{
		$date = new DateTime($this->start_time);
		return $date->format('l n/j/Y');
	}

}