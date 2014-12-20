<?php

class ProfilesTableSeeder extends Seeder {

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
		Profile::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		$i = 1;

		foreach(range(1, 30) as $index)
		{
			Profile::create([
				'user_id' => $i,
				'location' => $faker->address,
				'bio' => $faker->catchPhrase
				]);
			$i++;
		}

		// $this->call('UserTableSeeder');
	}

}
