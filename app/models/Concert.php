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

}