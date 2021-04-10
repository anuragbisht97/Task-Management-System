<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	* Seed the application's database.
	*
	* @return void
	*/
	public function run()
	{
		// \App\Models\User::factory(10)->create();
		$this->call([
			ProjectSeeder::class,
			TaskSeeder::class,
			UserSeeder::class
			]);
		}
	}
