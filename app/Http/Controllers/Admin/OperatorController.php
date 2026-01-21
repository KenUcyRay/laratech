<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OperatorController extends Controller
{
    public function index(): View
    {
        $operators = User::where('role', 'operator')->withTrashed()->latest()->paginate(10);
        return view('admin.operators.index', compact('operators'));
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('admin.operators.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => 'operator',
        ]);

        return redirect()->route('admin.operators.index')->with('success', 'Operator created successfully.');
    }

    public function show(User $operator): View
    {
        return view('admin.operators.show', compact('operator'));
    }

    public function edit(User $operator): RedirectResponse
    {
        return redirect()->route('admin.operators.index');
    }

    public function update(Request $request, User $operator): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($operator->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $operator->update($data);

        return redirect()->route('admin.operators.index')->with('success', 'Operator updated successfully.');
    }

    public function destroy(User $operator): RedirectResponse
    {
        $operator->delete();

        return redirect()->route('admin.operators.index')->with('success', 'Operator deleted successfully.');
    }

    public function restore(string $id): RedirectResponse
    {
        $operator = User::onlyTrashed()->findOrFail($id);
        $operator->restore();

        return redirect()->route('admin.operators.index')->with('success', 'Operator restored successfully.');
    }
}