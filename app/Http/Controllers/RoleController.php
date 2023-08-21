<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        $user = User::with('role')->find(Auth::id());

        // overwrite
        $user = $user->toArray();
        $user['role'] = $user['role']['name'];

        $roles = Role::all()->toArray();

        foreach ($roles as $key => $role) {
            $roles[$key]['created_at'] = date("Y-m-d", strtotime($role['created_at']));
        }
        // dd($roles);
        return Inertia::render('Roles', [
          'user' => $user,
          'roles' => $roles
        ]);
    }

    public function create(Request $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();
        $role = $role->toArray();
        $role['created_at'] = date("Y-m-d", strtotime($role['created_at']));
        return response()->json(['title' => 'Role successfully added', 'role' => $role]);
    }
}
