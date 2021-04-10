<?php

namespace Database\Seeders;

use App\Models\Task;
use Facade\Ignition\Support\FakeComposer;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
	public function run()
	{
		Task::factory(4)->create();
	}
}
