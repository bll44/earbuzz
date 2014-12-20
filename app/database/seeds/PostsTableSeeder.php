<?php

class PostsTableSeeder extends Seeder {

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
		Post::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		foreach(range(1, 30) as $index)
		{
			// MYSQL
			$userId = User::orderBy(DB::raw('RAND()'))->first()->id;

			// SQLITE
			// $userId = User::orderBy(DB::raw('random()'))->first()->id;

			Post::create([
				'user_id' => $userId,
				'title' => $faker->name($gender = null|'male'|'female'),
				'body' => $faker->catchPhrase
			]);
		}

		// $this->call('UserTableSeeder');
	}

}
