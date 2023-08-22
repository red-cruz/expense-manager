<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function () {
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/login', function () {
        return Inertia::render('Auth/Login', [
          'user' => ['name' => 'blue', 'age' => 21, 'role' => 'user'],
          'roles' => ['test' => 'data'],
        ]);
    })->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/logout', [LogoutController::class, 'logout']);

    Route::middleware('admin')->group(function () {
        // roles
        // Route::get('/{roles?}', [RoleController::class, 'index'])->where('roles', '[\/\w\.-]*')->name('roles.index');
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::post('/role:create', [RoleController::class, 'create']);
        Route::post('/role:update', [RoleController::class, 'update']);
        Route::post('/role:delete', [RoleController::class, 'delete']);

        // users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/user:create', [UserController::class, 'create']);
        Route::post('/user:update', [UserController::class, 'update']);
        Route::post('/user:delete', [UserController::class, 'delete']);
    });
});
