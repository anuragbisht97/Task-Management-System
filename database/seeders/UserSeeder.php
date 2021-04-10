<?php

namespace Database\Seeders;

use App\Models\User;
use Facade\Ignition\Support\FakeComposer;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	public function run()
	{
		User::factory(8)->create();
	}
}
