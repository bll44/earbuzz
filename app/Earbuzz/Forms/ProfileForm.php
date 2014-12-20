<?php

namespace Earbuzz\Forms;

use Laracasts\Validation\FormValidator;

class ProfileForm extends FormValidator {

	protected $rules = [
	'location' 			=> 'required',
	'bio' 				=> 'required',
	// 'twitter_username' 		=> 'required',
	// 'lastfm_username' 		=> 'required',
	// 'facebook_username' 		=> 'required'
	];

}