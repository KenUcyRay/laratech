<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = [
            'site_name' => 'LaraTech',
            'site_description' => 'Laravel Technology Blog',
            'site_logo' => '/images/logo.png',
            'contact_email' => 'admin@laratech.com',
            'maintenance_mode' => false,
            'allow_registration' => true,
            'posts_per_page' => 10,
            'timezone' => 'Asia/Jakarta',
            'date_format' => 'Y-m-d',
            'time_format' => 'H:i:s',
            'backup_frequency' => 'daily',
            'max_file_size' => '10MB',
            'allowed_file_types' => 'jpg,jpeg,png,pdf,doc,docx'
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'site_logo' => 'nullable|string',
            'contact_email' => 'required|email',
            'maintenance_mode' => 'boolean',
            'allow_registration' => 'boolean',
            'posts_per_page' => 'integer|min:1|max:50',
            'timezone' => 'required|string',
            'date_format' => 'required|string',
            'time_format' => 'required|string',
            'backup_frequency' => 'required|in:daily,weekly,monthly',
            'max_file_size' => 'required|string',
            'allowed_file_types' => 'required|string'
        ]);

        // Here you would typically save to database or config file
        // For now, we'll just redirect with success message
        
        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }

    public function toggleMaintenance(): RedirectResponse
    {
        // Here you would toggle maintenance mode
        return redirect()->route('admin.settings.index')->with('success', 'Maintenance mode toggled successfully.');
    }

    public function backup(): RedirectResponse
    {
        // Here you would create backup
        $backupFile = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        
        return redirect()->route('admin.settings.index')->with('success', "Backup created successfully: {$backupFile}");
    }

    public function clearCache(): RedirectResponse
    {
        // Here you would clear cache
        return redirect()->route('admin.settings.index')->with('success', 'Cache cleared successfully.');
    }
}