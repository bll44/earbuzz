<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConcertsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('concerts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->dateTime('start_time');
			$table->dateTime('end_time');
			$table->mediumText('description')->nullable();
			$table->integer('artist_id');
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
		Schema::drop('concerts');
	}

}
