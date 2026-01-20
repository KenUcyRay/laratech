<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => 'LaraTech',
            'site_description' => 'Laravel Technology Blog',
            'site_logo' => '/images/logo.png',
            'contact_email' => 'admin@laratech.com',
            'maintenance_mode' => false,
            'allow_registration' => true,
            'posts_per_page' => 10
        ];

        return response()->json([
            'status' => 'success',
            'data' => $settings
        ]);
        
        // Blade View (commented)
        // return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'site_logo' => 'nullable|string',
            'contact_email' => 'required|email',
            'maintenance_mode' => 'boolean',
            'allow_registration' => 'boolean',
            'posts_per_page' => 'integer|min:1|max:50'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengaturan berhasil diupdate',
            'data' => $validated
        ]);
        
        // Blade View (commented)
        // return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil diupdate');
    }

    public function toggleMaintenance()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Mode maintenance berhasil diubah',
            'data' => ['maintenance_mode' => true]
        ]);
        
        // Blade View (commented)
        // return redirect()->route('admin.settings.index')->with('success', 'Mode maintenance berhasil diubah');
    }

    public function backup()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Backup berhasil dibuat',
            'data' => [
                'backup_file' => 'backup_' . date('Y-m-d_H-i-s') . '.sql',
                'created_at' => now()
            ]
        ]);
        
        // Blade View (commented)
        // return redirect()->route('admin.settings.index')->with('success', 'Backup berhasil dibuat');
    }

    public function clearCache()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Cache berhasil dibersihkan'
        ]);
        
        // Blade View (commented)
        // return redirect()->route('admin.settings.index')->with('success', 'Cache berhasil dibersihkan');
    }
}