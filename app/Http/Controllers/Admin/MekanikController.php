<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MekanikController extends Controller
{
    public function index(): View
    {
        $mekaniks = User::where('role', 'mekanik')->withTrashed()->latest()->get();
        return view('admin.mekaniks.index', compact('mekaniks'));
    }

    public function create(): View
    {
        return view('admin.mekaniks.create');
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
            'role' => 'mekanik',
        ]);

        return redirect()->route('admin.mekaniks.index')->with('success', 'Mekanik created successfully.');
    }

    public function show(User $mekanik): View
    {
        return view('admin.mekaniks.show', compact('mekanik'));
    }

    public function edit(User $mekanik): View
    {
        return view('admin.mekaniks.edit', compact('mekanik'));
    }

    public function update(Request $request, User $mekanik): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($mekanik->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $mekanik->update($data);

        return redirect()->route('admin.mekaniks.index')->with('success', 'Mekanik updated successfully.');
    }

    public function destroy(User $mekanik): RedirectResponse
    {
        $mekanik->delete();

        return redirect()->route('admin.mekaniks.index')->with('success', 'Mekanik deleted successfully.');
    }

    public function restore(string $id): RedirectResponse
    {
        $mekanik = User::onlyTrashed()->findOrFail($id);
        $mekanik->restore();

        return redirect()->route('admin.mekaniks.index')->with('success', 'Mekanik restored successfully.');
    }
}