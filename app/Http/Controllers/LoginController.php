<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // First check if the user exists
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found with this email.');
        }
        
        // Then attempt authentication without role restriction
        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('login')->with('error', 'Invalid password.');
        }
        
        // Check if authenticated user is an admin
        if (!auth()->user()->isAdmin()) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'You are not authorized as an admin.');
        }
        
        // Successful login, redirect to dashboard
        return redirect()->route('admin.dashboard');
    }

    /**
     * Log the user out
     */
    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
