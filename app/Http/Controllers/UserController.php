<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function logout()
    {
        auth()->logout();
        return redirect("/");
    }
    public function register(Request $request)
    {
        // 1. Validation - If this fails, Laravel handles the redirect for you automatically.
        $incomingFields = $request->validate([
            "name" => ["required", "min:3", Rule::unique('users', 'name')],
            "email" => ["required", "email", Rule::unique('users', 'email')],
            "password" => ["required", "min:8"]
        ]);

        // 2. Prepare data & create user
        $incomingFields["password"] = bcrypt($incomingFields["password"]);
        $user = User::create($incomingFields);

        // 3. Log the user in
        auth()->login($user);

        // 4. Redirect with success message
        return redirect('/')->with('success', 'Congrats! Your account is ready.');
    }
    public function login(Request $request)
    {
        $incommingFields = $request->validate([
            'email' => ['required', "email"],
            'password' => 'required'
        ]);

        if (
            auth()->attempt([
                'email' => $incommingFields['email'],
                'password' => $incommingFields['password']
            ])
        ) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Logged in successfully!');
        }

        // This triggers if the name/password don't match the DB
        return redirect('/login')->with('failure', 'Invalid username or password.');
    }
}
