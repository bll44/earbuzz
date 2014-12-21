<?php

class FavoritesTableSeeder extends Seeder {

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
		DB::table('favorites')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		foreach(range(1, 30) as $index)
		{
			// MYSQL
			$artist = Artist::orderBy(DB::raw('RAND()'))->first();
			User::orderBy(DB::raw('RAND()'))->first()->favorites()->attach($artist->id);

			// SQLITE
			// $post = Post::orderBy(DB::raw('random()'))->first();
			// $userId = User::orderBy(DB::raw('random()'))->first()->favorites()->attach($post->id);
		}

		// $this->call('UserTableSeeder');
	}

}
