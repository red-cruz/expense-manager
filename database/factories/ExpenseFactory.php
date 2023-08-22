<?php

namespace Database\Factories;

use App\Models\ExpenseCategory;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'user_id' => User::all()->random()->id,
          'expense_category_id' => ExpenseCategory::all()->random()->id,
          'amount' => fake()->unique()->numberBetween(1, 999),
          'entry_date' => fake()->date()
        ];
    }
}
