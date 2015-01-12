<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session',

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
		'Facebook' => array(
			'client_id'     => '1583085905255001',
			'client_secret' => '8c76cf870ac9268ae40e84847a316d43',
			'scope'         => array(),
			),
		/**
		 * Google
		 */
		'Google' => array(
			'client_id'     => '736344499201-5msctng1s17fr9mtf02an95ttlnfgv74.apps.googleusercontent.com',
			'client_secret' => 'WLmAlkO7Q3xH3Azdx0TFXDMk',
			'scope'         => array('userinfo_email', 'userinfo_profile'),
			),
		/**
		 * Twitter
		 */
		'Twitter' => array(
			'client_id'     => 'DvUYQGqIul19eQWTELyiU0KIn',
			'client_secret' => 'FZ6taHBNfushoDQR58hKIOxMcuzptuqiqz58axnPqlWqwyyZop',
			// No scope - oauth1 doesn't need scope
			),
		),


	);

