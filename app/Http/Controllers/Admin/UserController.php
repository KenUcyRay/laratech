<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        
        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
        
        // Blade View (commented)
        // return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'in:admin,user',
            'status' => 'in:active,inactive'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'] ?? 'user',
            'status' => $validated['status'] ?? 'active'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil ditambahkan',
            'data' => $user
        ], 201);
        
        // Blade View (commented)
        // return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
        
        // Blade View (commented)
        // return view('admin.users.show', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'in:admin,user',
            'status' => 'in:active,inactive'
        ]);

        if ($request->password) {
            $validated['password'] = bcrypt($request->password);
        }

        $user->update($validated);
        
        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil diupdate',
            'data' => $user
        ]);
        
        // Blade View (commented)
        // return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil dihapus'
        ]);
        
        // Blade View (commented)
        // return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status user berhasil diubah',
            'data' => $user
        ]);
        
        // Blade View (commented)
        // return redirect()->route('admin.users.index')->with('success', 'Status user berhasil diubah');
    }

    // Blade View Methods (commented)
    // public function create()
    // {
    //     return view('admin.users.create');
    // }
    //
    // public function edit($id)
    // {
    //     $user = User::findOrFail($id);
    //     return view('admin.users.edit', compact('user'));
    // }
}