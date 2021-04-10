<?php

namespace Database\Seeders;

use App\Models\Project;
use Facade\Ignition\Support\FakeComposer;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
	public function run()
	{
		Project::factory(2)->create();
	}
}
