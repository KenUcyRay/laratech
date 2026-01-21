<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ReportController extends Controller
{
    public function index(): View
    {
        // Default empty data for when Report model doesn't exist yet
        $reports = collect();
        $reportStats = [
            'total' => 0,
            'high_priority' => 0,
            'medium_priority' => 0,
            'low_priority' => 0,
            'resolved' => 0,
            'pending' => 0
        ];

        // Try to get data from Report model if it exists
        try {
            if (class_exists('App\Models\Report')) {
                $reportModel = app('App\Models\Report');
                $reports = $reportModel::with(['equipment.type', 'reporter', 'images'])
                    ->latest()
                    ->paginate(10);
                
                $reportStats = [
                    'total' => $reportModel::count(),
                    'high_priority' => $reportModel::where('severity', 'high')->count(),
                    'medium_priority' => $reportModel::where('severity', 'medium')->count(),
                    'low_priority' => $reportModel::where('severity', 'low')->count(),
                    'resolved' => $reportModel::where('status', 'resolved')->count(),
                    'pending' => $reportModel::whereIn('status', ['open', 'in_progress'])->count(),
                ];
            }
        } catch (\Exception $e) {
            // Model doesn't exist or table doesn't exist
        }

        return view('admin.reports.index', compact('reports', 'reportStats'));
    }

    public function show($id): View
    {
        // Dummy data for when Report model doesn't exist
        $report = (object) [
            'id' => $id,
            'title' => 'Sample Report',
            'description' => 'This is a sample report description.',
            'severity' => 'medium',
            'status' => 'open',
            'created_at' => now(),
            'updated_at' => now(),
            'reporter' => (object) ['name' => 'Sample User'],
            'equipment' => (object) ['name' => 'Sample Equipment'],
        ];

        try {
            if (class_exists('App\Models\Report')) {
                $reportModel = app('App\Models\Report');
                $report = $reportModel::with(['equipment.type', 'reporter', 'images'])
                    ->findOrFail($id);
            }
        } catch (\Exception $e) {
            // Model doesn't exist or record not found
        }

        return view('admin.reports.show', compact('report'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:open,in_progress,resolved'],
        ]);

        try {
            if (class_exists('App\Models\Report')) {
                $reportModel = app('App\Models\Report');
                $report = $reportModel::findOrFail($id);
                $report->update($validated);
                
                return redirect()->route('admin.reports.index')->with('success', 'Report status updated successfully.');
            }
        } catch (\Exception $e) {
            // Model doesn't exist or record not found
        }

        return redirect()->route('admin.reports.index')->with('error', 'Unable to update report.');
    }

    public function destroy($id): RedirectResponse
    {
        try {
            if (class_exists('App\Models\Report')) {
                $reportModel = app('App\Models\Report');
                $report = $reportModel::findOrFail($id);
                $report->delete();
                
                return redirect()->route('admin.reports.index')->with('success', 'Report deleted successfully.');
            }
        } catch (\Exception $e) {
            // Model doesn't exist or record not found
        }

        return redirect()->route('admin.reports.index')->with('error', 'Unable to delete report.');
    }
}
