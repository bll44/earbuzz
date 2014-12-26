<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Laravel\Cashier\BillableInterface;
use Laravel\Cashier\BillableTrait;
use Cmgmyr\Messenger\Traits\Messagable;
use \Illuminate\Database\Eloquent\ModelNotFoundException;

class User extends Eloquent implements UserInterface, RemindableInterface, BillableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	public $timestamps = false;

	use BillableTrait;
	use Messagable;

	/**
	 *
	 * @var string
	 */
	protected $dates = ['trial_ends_at', 'subscription_ends_at'];

	/**
	 * Fillable fields.
	 *
	 * @var array
	 */
	protected $fillable = [
	'username', 'email', 'password', 'displayname'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function setPasswordAttribute($password)
	{
		$this->attributes['password'] = Hash::make($password);
	}

	public function profile()
	{
		return $this->hasOne('Profile');
	}

	public function isCurrent()
	{
		if (Auth::guest()) return false;

		return Auth::user()->id == $this->id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function streamingKey()
	{
		return $this->hasOne('StreamingKey');
	}

	public function artist()
	{
		return $this->hasOne('Artist');
	}

	public function favorites()
	{
		return $this->belongsToMany('Artist', 'favorites')->withTimestamps(); //defaults to post_user, second argument is override table
	}

	public static function findByUsernameOrFail(
		$username,
		$columns = array('*')
		) {
		if ( ! is_null($user = static::whereUsername($username)->first($columns))) {
			return $user;
		}

		throw new ModelNotFoundException;
	}

}
