<?php

class StreamingKey extends Eloquent {

	protected $table = 'streaming_keys';
	protected $prefix = 'buzzlive_';
	protected $guarded = array('prefix');

	public function __construct()
	{
		$this->generate();
	}

	public function generate()
	{
		$this->key = uniqid($this->prefix, true);
		return $this;
	}

	// accepts a User object if one is provided
	// otherwise defaults to the currently authenticated User
	public function resetKey($user = null)
	{
		if(is_null($user)) $user = Auth::user();

		if(null !== $user->streamingKey)
		{
			$user->streamingKey->generate()->save();
			return $user->streamingKey->key;
		}
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

}