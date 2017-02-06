<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use YouInteract\User;

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->delete();

		User::create(['name' => 'admin', 'email' => 'anjo2cp@gmail.com', 'password' => '$2y$10$cHiBcAZqKXL8s3gau.OyReAYt3EPThop/thDMd8dSqSDgvOvlkTfy']);
	}

}
