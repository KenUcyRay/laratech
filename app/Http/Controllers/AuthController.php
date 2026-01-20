<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            
            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ]);
            
            // Blade View (commented)
            // return redirect()->route('admin.dashboard');
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Email atau password salah'
        ], 401);
        
        // Blade View (commented)
        // return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil'
        ]);
        
        // Blade View (commented)
        // Auth::logout();
        // return redirect()->route('login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 201);

        // Blade View (commented)
        // Auth::login($user);
        // return redirect()->route('admin.dashboard');
    }

    public function profile(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => $request->user()
        ]);
        
        // Blade View (commented)
        // return view('auth.profile', ['user' => $request->user()]);
    }

    // Blade View Methods (commented)
    // public function showLogin()
    // {
    //     return view('auth.login');
    // }
    //
    // public function showRegister()
    // {
    //     return view('auth.register');
    // }
}
