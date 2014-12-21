<?php

class ArtistsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$faker = Faker\Factory::create();

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		Artist::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		foreach(range(1, 30) as $index)
		{

			$artistId = User::orderBy(DB::raw('RAND()'))->first();

			Artist::create([
				'user_id' => $artistId->id,
				'name' => $artistId->displayname
			]);
		}

		// $this->call('UserTableSeeder');
	}

}
