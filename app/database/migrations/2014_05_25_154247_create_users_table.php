<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('username');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->string('displayname', 255);
			$table->enum('notify', ['y', 'n'])->default('y');
			$table->string('type', 255)->nullable();
			// $table->integer('type_id', 11);
			// $table->string('billing_id')->nullable();
			$table->string('provider')->nullable();
			$table->string('provider_uid')->unique()->nullable();
			$table->string('profile_url')->nullable();
			$table->string('photo_url')->nullable();
			$table->string('persist_code')->nullable();
			$table->timestamp('activated_at')->nullable();
			$table->timestamp('last_login')->nullable();
			$table->string('remember_token')->nullable();
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
		Schema::drop('users');
	}

}
