<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Error;
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
        try {
            $validated = $request->validate([
              'name' => 'required|unique:roles|max:255',
              'description' => 'required|max:255',
            ]);
            $role = new Role();
            $role->name = $validated['name'];
            $role->description = $validated['description'];
            $role->save();
            $role = $role->toArray();
            $role['created_at'] = date("Y-m-d", strtotime($role['created_at']));
            return response()->json([
              'message' => $role['name'].' role has been added',
              'role' => $role
            ]);
        } catch(\Illuminate\Validation\ValidationException $err) {
            return response()->json(['title' => 'Invalid input', 'errors' => $err->errors()], 422);
        } catch (\Throwable $th) {
            return response()->json(['title' => 'Error: '.$th->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
              'id' => 'exists:roles,id',
              'name' => 'required|unique:roles|max:255',
              'description' => 'required|max:255',
            ]);
            $role = Role::find($validated['id']);
            $role->name = $validated['name'];
            $role->description = $validated['description'];
            $role->save();
            $role = $role->toArray();
            $role['created_at'] = date("Y-m-d", strtotime($role['created_at']));
            return response()->json([
              'message' => $role['name'].' has been updated',
              'role' => $role
            ]);
        } catch(\Illuminate\Validation\ValidationException $err) {
            return response()->json(['title' => 'Invalid input', 'errors' => $err->errors()], 422);
        } catch (\Throwable $th) {
            return response()->json(['title' => 'Error: '.$th->getMessage()], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $validated = $request->validate([
              'deleteId' => 'exists:roles,id',
            ]);
            $role = Role::find($validated['deleteId']);
            $role->delete();
            return response()->json([
              'message' => $role->name.' has been deleted'
            ]);
        } catch(\Illuminate\Validation\ValidationException $err) {
            return response()->json(['title' => 'Invalid input', 'errors' => $err->errors()], 422);
        } catch (\Throwable $th) {
            return response()->json(['title' => 'Error: '.$th->getMessage()], 500);
        }
    }
}
