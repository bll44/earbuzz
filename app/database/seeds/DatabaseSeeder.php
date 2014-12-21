<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UsersTableSeeder');
		$this->call('ArtistsTableSeeder');
		$this->call('ProfilesTableSeeder');
		$this->call('FavoritesTableSeeder');
		$this->call('GenresTableSeeder');
	}

}
