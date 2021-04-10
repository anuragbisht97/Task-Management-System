<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
	/**
	* The name of the factory's corresponding model.
	*
	* @var string
	*/
	protected $model = User::class;

	/**
	* Define the model's default state.
	*
	* @return array
	*/
	public function definition()
	{
		static $number = 1;

		$strings = array(
			'admin',
			'local',
		);

		return [
			'user_id' => $number++,
			'name' => $this->faker->name(),
			'phone_number' => rand(7000000000,9999999999),
			'email' => $this->faker->unique()->safeEmail,
			'email_verified_at' => now(),
			'address' => $this->faker->address(),
			'designation' => $this->faker->name(),
			'role' => $strings[array_rand($strings)],
			'user_status' => rand(0,1),
			'password' => Hash::make($this->faker->name()),
			'remember_token' => Str::random(10)
		];
	}

	/**
	* Indicate that the model's email address should be unverified.
	*
	* @return \Illuminate\Database\Eloquent\Factories\Factory
	*/
	public function unverified()
	{
		return $this->state(function (array $attributes) {
			return [
				'email_verified_at' => null,
			];
		});
	}
}
