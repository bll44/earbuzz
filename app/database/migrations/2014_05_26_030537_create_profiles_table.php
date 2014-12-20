<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profiles', function(Blueprint $table) {
			$table->increments('id');
			// $table->unsignedInteger('user_id');
			// $table->foreign('user_id')
			// 		->references('id')
			// 		->on('users')
			// 		->onUpdate('cascade');
			$table->integer('user_id')->unsigned();
			// $table->integer('email')->unsigned();
			$table->string('display_name')->nullable();
			$table->string('location')->nullable();
			$table->text('bio')->nullable();
			$table->string('twitter_username')->nullable();
			$table->string('facebook_username')->nullable();
			$table->string('lastfm_username')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('profiles');
	}

}
