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

	protected static function createArchive($album)
	{
		$music_bucket = Config::get('constants.MUSIC_STORAGE_BUCKET_DEV');
		$album_location = "{$music_bucket}/{$album->artist->id}/{$album->name}";

		$zip = new ZipArchive;
		$filename = "{$album_location}/{$album->name}.zip";
		if($zip->open($filename, ZipArchive::CREATE))
		{
			foreach(new DirectoryIterator($album_location) as $file)
			{
				if(substr($file->getBasename(), strrpos($file->getBasename(), '.')) === '.mp3')
				{
					$zip->addFile("{$file->getRealPath()}", $file->getBasename());
				}
			}
			$zip->close();
			return $filename;
		}
		else
		{
			return false;
		}
	}

	public static function download($id)
	{
		$album = Album::with('Artist')->where('id', $id)->first();
		$archive = static::createArchive($album);

		// header('Content-Description: File Transfer');
		// header('Content-Type: application/octet-stream');
		// header("Content-Disposition: attachment; filename=\"{$album->name}.zip\"");
		// header('Expires: 0');
		// header('Content-Lenght: ' . filesize($archive));

		// readfile($archive);

		return Response::download($archive);
	}

}