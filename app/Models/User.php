<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'plain_pass',
        'password'
    ];
    protected $hidden = [
        'plain_pass',
        'password',
    ];
    protected $casts = [
        'password' => 'hashed',
    ];

    public function role(): HasOne
    {
        return $this->hasOne(Role::class, 'id');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
