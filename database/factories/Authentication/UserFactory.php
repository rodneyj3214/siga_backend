<?php

namespace Database\Factories\Authentication;

use App\Models\Authentication\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class UserFactory extends Factory
{

    protected $model = User::class;

    public function definition()
    {
        return [
            'identification' => $this->faker->numberBetween($min = 1000000000, $max = 9999999999),
            'username' => $this->faker->numberBetween($min = 1000000000, $max = 9999999999),
            'first_name' => $this->faker->firstNameMale,
            'second_name' => $this->faker->firstNameMale,
            'first_lastname' => $this->faker->lastName,
            'second_lastname' => $this->faker->lastName,
            'personal_email' => $this->faker->unique()->safeEmail,
            'birthdate' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'username' => $this->faker->numberBetween($min = 1000000000, $max = 9999999999),
            'email' => $this->faker->unique()->safeEmail,
            'status_id' => 1,
            'password' => '$2y$10$fojHGTDRXyjmcXSgE7/1xOubqUrv03AiQb.9lKKH4PxJfkoluZGxK', // 12345678
        ];
    }
}
