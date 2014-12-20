<?php

class UsersTableSeeder extends Seeder {

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
		DB::table('threads')->truncate();
		DB::table('messages')->truncate();
		DB::table('participants')->truncate();
		User::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		
		$roles = array('artist', 'fan');

		foreach(range(1, 30) as $index)
		{
			User::create([
				'username' => $faker->userName,
				'email' => $faker->safeEmail,
				'displayname' => $faker->name,
				'password' => '1234',
				'type' => $roles[rand(0, 1)],
				]);
		}

		// $this->call('UserTableSeeder');
	}

}
