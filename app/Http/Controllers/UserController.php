<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with('role')->find(Auth::id());
        $user = $user->toArray();
        $user['role'] = $user['role']['name'];

        $users = User::all()->toArray();
        $roles = Role::all();

        foreach ($users as $key => $userItem) {
            $users[$key]['role'] = $roles->find($userItem['role_id']);
            $users[$key]['created_at'] = date("Y-m-d", strtotime($userItem['created_at']));
        }
        return Inertia::render('Users', [
          'user' => $user,
          'users' => $users,
          'roles' => $roles
        ]);
    }

    public function create(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->save();
        $user = $user->toArray();
        $user['created_at'] = date("Y-m-d", strtotime($user['created_at']));
        $user['role'] = Role::find($request->role);
        return response()->json(['message' => 'User successfully added', 'user' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->save();
        $user = $user->toArray();
        $user['created_at'] = date("Y-m-d", strtotime($user['created_at']));
        $user['role'] = Role::find($request->role);
        return response()->json(['message' => 'User successfully updated', 'user' => $user]);
    }

    public function delete(Request $request)
    {
        $user = User::find($request->deleteId);
        $user->delete();
        return response()->json([
          'message' => 'Successfully deleted'
        ]);
    }
}
