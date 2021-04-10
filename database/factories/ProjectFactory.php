<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
	protected $model = Project::class;

	public function definition()
	{
		static $number = 1;

		return [
			'project_id' => $number++,
			'project_name' => $this->faker->name,
			'summary' => $this->faker->sentence(),
			'description' => $this->faker->sentence(),
			'project_status' => rand(0,1),
			'project_created_by' => rand(1,8)
		];
	}
}
