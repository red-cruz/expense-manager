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
        foreach ($users as $key => $user) {
            $users[$key]['role'] = Role::find($user['role_id']);
            $users[$key]['created_at'] = date("Y-m-d", strtotime($user['created_at']));
        }
        return Inertia::render('Users', [
          'user' => $user,
          'users' => $users
        ]);
    }

    public function create(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->save();
        $user = $user->toArray();
        $user['created_at'] = date("Y-m-d", strtotime($user['created_at']));
        return response()->json(['message' => 'User successfully added', 'user' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->save();
        $user = $user->toArray();
        $user['created_at'] = date("Y-m-d", strtotime($user['created_at']));
        return response()->json(['message' => 'User successfully updated', 'user' => $user]);
    }

    public function delete(Request $request)
    {
        // $user = User::find($request->userId);
        // $user->delete();
        return response()->json([
          'message' => 'Successfully deleted',
          'userId' => $request->id
        ]);
    }
}
