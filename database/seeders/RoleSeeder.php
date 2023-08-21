<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // default role
        Role::factory()->create([
          'name' => 'Admin',
          'description' => 'Administrator'
        ]);
        Role::factory()->create([
          'name' => 'User',
          'description' => 'User'
        ]);
        // Role::factory(2)->create();
    }
}
