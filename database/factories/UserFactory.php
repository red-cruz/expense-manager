<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $password = fake()->password(8, 8);
        $factory = [
          'role_id' => Role::all()->random()->id,
          'name' => fake()->name(),
          'email' => fake()->unique()->safeEmail(),
          'password' => password_hash($password, PASSWORD_DEFAULT),
        ];
            $factory['plain_pass'] = $password;
        return $factory;
    }
}
