<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); // Adjust if your login blade file is named differently
    }

    public function processLogin(Request $request)
    {
        // Validate input
        $request->validate([
            'email_or_username' => 'required',
            'password' => 'required',
            'role' => 'required|in:user,admin'
        ]);

        // Determine if input is email or username
        $field = filter_var($request->input('email_or_username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Fetch user based on username/email
        $user = User::where($field, $request->input('email_or_username'))->first();

        if (!$user) {
            return back()->withErrors(['login_error' => ucfirst($field) . ' does not exist.']);
        }

        // Check if the password matches
        if (!Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors(['login_error' => 'Incorrect password.']);
        }

        // Verify role
        if ($user->role !== $request->input('role')) {
            return back()->withErrors(['login_error' => 'Invalid role for this account.']);
        }

        // Log the user in
        Auth::login($user);

        // Redirect based on role
        return $user->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logs out all roles
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
