<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
	protected $model = Task::class;

	public function definition()
	{
		static $number = 1;

		return [
			'project_id' => rand(1,4),
			'task_name' => $this->faker->name,
			'task_id' =>  $number++,
			'summary' => $this->faker->sentence(),
			'description' => $this->faker->sentence(),
			'task_status' => rand(0,1),
			'task_created_by' => rand(1,8),
			'assign_to' => rand(1,8),
			'assign_by' => rand(1,8)
		];
	}
}
