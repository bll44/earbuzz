<?php

namespace Earbuzz\Forms;

use Laracasts\Validation\FormValidator;

class RegistrationForm extends FormValidator {

	protected $rules = [
	'displayname' 		=> 'required',
	'username' 			=> 'required|unique:users',
	'email' 			=> 'required|email|unique:users',
	'password' 			=> 'required|confirmed'
	];

}