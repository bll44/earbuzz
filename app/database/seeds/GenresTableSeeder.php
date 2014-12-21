<?php

class GenresTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('genres')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		$genres = array(
			'acoustic',
			'ambient',
			'blues',
			'classical',
			'country',
			'electronic',
			'emo',
			'folk',
			'hardcore',
			'hip hop',
			'indie',
			'jazz',
			'latin',
			'metal',
			'pop',
			'pop punk',
			'punk',
			'reggae',
			'rnb',
			'rock',
			'soul',
			'world',
			'60s',
			'70s',
			'80s',
			'90s',
		);

		foreach($genres as $g)
		{
			Genre::create([
				'name' => $g,
			]);
		}

		// $this->call('UserTableSeeder');
	}

}
