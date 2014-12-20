<?php

class Post extends Eloquent {

	/**
	 * Fillable fields.
	 *
	 * @var array
	 */
	protected $fillable = [
	'title', 'user_id', 'body'
	];
}