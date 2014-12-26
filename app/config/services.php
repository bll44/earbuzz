<?php
return array(
	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/
	'mailgun' => array(
		'domain' => '',
		'secret' => '',
	),
	'mandrill' => array(
		'secret' => 'GSZrzMPalN5oOfPlRNqkIA',
	),
	'stripe' => array(
		'model'  => 'User',
		'secret' => 'sk_test_uljEMPjWuWYRKjWpYs5ba5d8',
	),
	'pusher' => [
		'public' => '999a6964f87015288a65',
		'secret' => 'ee1d6acc6f9f8dfdf94c',
		'app_id' => '80855'
	]
);