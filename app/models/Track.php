<?php

class Track extends Eloquent {

	protected $table = 'tracks';

	public function album()
	{
		return $this->belongsTo('Album');
	}

	public function getHMSString()
	{
	    $hours = floor($this->duration / 60 / 60);
	    $minutes = floor($this->duration / 60 - ($hours * 60));
	    $seconds = $this->duration - ($minutes * 60) - ($hours * 60 * 60);

	    // format single digit seconds with leading zero "0" for display purposes
	    if(strlen((string) $seconds) < 2) $seconds = '0' . $seconds;

	    if($hours < 1)
	    	return $minutes . ':' . $seconds;

	    return $hours . ':' . $minutes . ':' . $seconds;
	}

	public static function download($id)
	{
		$track = Track::with('Album')->where('id', $id)->first();
		$artist = $track->album->artist;

		$filelocation = Config::get('constants.MUSIC_STORAGE_BUCKET') . '/' . $artist->id . '/' . $track->album->name;
		$file = $filelocation . '/' . $track->name . '.mp3';

		return Response::download($file);

		// header('Content-Description: File Transfer');
		// header('Content-Type: application/octet-stream');
		// header("Content-Disposition: attachment; filename=\"{$track->name}.mp3\"");
		// header('Expires: 0');
		// header('Content-Lenght: ' . filesize($file));

		// if(readfile($file))
		// 	return true;
		// else
		// 	return false;
	}

}