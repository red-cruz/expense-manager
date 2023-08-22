<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('plain_pass')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });
        // default admin
        $password = 'Pass@123';
        $factory = [
        'role_id' => Role::first()->id,
        'name' => 'Raymark E. Dela Cruz',
        'email' => 'admin@email.com',
        'password' => password_hash($password, PASSWORD_DEFAULT),
        ];
        $factory['plain_pass'] = $password;
        User::factory()->create($factory);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
