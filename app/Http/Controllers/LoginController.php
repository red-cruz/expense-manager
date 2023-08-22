<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect(RouteServiceProvider::HOME);
        }
        return response()->json(['title' => 'Wrong password or email'], 401);
    }
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'previous_password' => ['required'],
                'password' => ['required'],
            ]);
            $password = $validated['password'];
            $user = User::find(Auth::id());

            if(!password_verify($validated['previous_password'], $user->password)) {
                throw new Error('Wrong password');
            }
                $user->plain_pass = $password;
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            $user->save();

            return response()->json([
              'title' => 'Your password has been updated'
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
