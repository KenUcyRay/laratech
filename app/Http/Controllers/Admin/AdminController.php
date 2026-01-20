<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_active_users' => User::where('status', 'active')->count(),
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Dashboard data',
            'data' => $stats
        ]);
        
        // Blade View (commented)
        // return view('admin.dashboard', compact('stats'));
    }

    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $admins
        ]);
        
        // Blade View (commented)
        // return view('admin.admins.index', compact('admins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,user'
        ]);

        $admin = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Admin berhasil ditambahkan',
            'data' => $admin
        ], 201);
        
        // Blade View (commented)
        // return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil ditambahkan');
    }

    public function show($id)
    {
        $admin = User::findOrFail($id);
        
        return response()->json([
            'status' => 'success',
            'data' => $admin
        ]);
        
        // Blade View (commented)
        // return view('admin.admins.show', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,user'
        ]);

        if ($request->password) {
            $validated['password'] = bcrypt($request->password);
        }

        $admin->update($validated);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Admin berhasil diupdate',
            'data' => $admin
        ]);
        
        // Blade View (commented)
        // return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil diupdate');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Admin berhasil dihapus'
        ]);
        
        // Blade View (commented)
        // return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil dihapus');
    }

    // Blade View Methods (commented)
    // public function create()
    // {
    //     return view('admin.admins.create');
    // }
    //
    // public function edit($id)
    // {
    //     $admin = User::findOrFail($id);
    //     return view('admin.admins.edit', compact('admin'));
    // }
}