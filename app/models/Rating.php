<?php

class Rating extends Eloquent {

	/**
	 * Fillable fields.
	 *
	 * @var array
	 */
	protected $fillable = [
	'user_id', 'post_id', 'rating'
	];
}