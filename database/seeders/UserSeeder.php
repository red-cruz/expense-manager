<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = 'Pass@123';
        $factory = [
        'role_id' => Role::first()->id,
        'name' => 'Raymark E. Dela Cruz',
        'email' => 'admin@email.com',
        'password' => password_hash($password, PASSWORD_DEFAULT),
        ];
        if(App::environment('local')) {
            $factory['plain_pass'] = $password;
        }

        // default admin
        User::factory()->create($factory);

        User::factory(3)
        ->has(Expense::factory()->count(1))
        ->create();
    }
}
