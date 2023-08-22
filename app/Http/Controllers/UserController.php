<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
        try {
            $validated = $request->validate([
              'name' => 'required|max:255',
              'email' => 'required|email|unique:users,email|max:255',
              'role' => 'exists:roles,id|Integer',
            ]);

            $password = $request->password ?? 'Pass@123'; // default password
            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role_id = $validated['role'];
            if(App::environment('local')) {
                $user->plain_pass = $password;
            }
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            $user->save();
            $user = $user->toArray();
            $user['created_at'] = date("Y-m-d", strtotime($user['created_at']));
            $user['role'] = Role::find($validated['role']);

            return response()->json([
              'message' => $user['name'].' has been added to users',
              'user' => $user
            ]);
        } catch(\Illuminate\Validation\ValidationException $err) {
            return response()->json([
              'title' => 'Invalid input',
              'errors' => $err->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
              'title' => 'Error: '.$th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
              'id' => 'exists:users,id|Integer',
              'name' => 'required|max:255',
              'email' => 'required|email|max:255',
              'role' => 'exists:roles,id|Integer',
            ]);

            $password = $request->password ?? 'Pass@123'; // default password
            $user = User::find($validated['id']);
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role_id = $validated['role'];
            if(App::environment('local')) {
                $user->plain_pass = $password;
            }
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            $user->save();
            $user = $user->toArray();
            $user['created_at'] = date("Y-m-d", strtotime($user['created_at']));
            $user['role'] = Role::find($validated['role']);

            return response()->json([
              'message' => $user['name'].' has been updated',
              'user' => $user
            ]);
        } catch(\Illuminate\Validation\ValidationException $err) {
            return response()->json([
              'title' => 'Invalid input',
              'errors' => $err->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
              'title' => 'Error: '.$th->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $validated = $request->validate([
              'deleteId' => 'exists:users,id',
            ]);
            $user = User::find($validated['deleteId']);
            foreach ($user->expenses as $expenses) {
                $expenses->delete();
            }
            $user->delete();
            return response()->json([
              'message' => $user->name.' has been deleted'
            ]);
        } catch(\Illuminate\Validation\ValidationException $err) {
            return response()->json([
              'title' => 'Invalid input',
              'errors' => $err->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
              'title' => 'Error: '.$th->getMessage()
            ], 500);
        }
    }
}
