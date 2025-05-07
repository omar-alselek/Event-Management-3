<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:organizer,attendee'],
            'phone' => ['nullable', 'string', 'max:20'],
            'organization' => ['nullable', 'string', 'max:255'],
            'document' => ['required_if:role,organizer', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'organization' => $request->organization,
            'is_approved' => $request->role === 'attendee',
        ]);

        if ($request->role === 'organizer') {
            $documentPath = $request->file('document')->store('organizer-documents', 'public');
            
            Organizer::create([
                'user_id' => $user->id,
                'document_path' => $documentPath,
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login credentials',
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        if ($user->role === 'organizer' && !$user->is_approved) {
            return response()->json([
                'message' => 'Your account is pending approval',
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function registerAttendee(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'attendee',
            'phone' => $request->phone,
            'is_approved' => true,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Attendee registration successful',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function registerOrganizer(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
            'organization' => ['required', 'string', 'max:255'],
            'document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'organizer',
            'phone' => $request->phone,
            'organization' => $request->organization,
            'is_approved' => false,
        ]);

        $documentPath = $request->file('document')->store('organizer-documents', 'public');

        Organizer::create([
            'user_id' => $user->id,
            'document_path' => $documentPath,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Organizer registration submitted and pending approval',
            'user' => $user,
            'token' => $token,
        ], 201);
    }
} 