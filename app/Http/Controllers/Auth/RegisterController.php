<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255', // Ensure username is validated
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            // Redirect back with validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }




        // Save the user to the database
        User::create([
            'username' => $request->username, // Save username correctly
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role
        ]);

        // Redirect to the home page with success message
        return redirect()->route('login')->with('success', 'Registration successful!');
    }
}
