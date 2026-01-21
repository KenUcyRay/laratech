<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Task;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $reports = Report::with(['equipment', 'reporter', 'task'])
            ->latest()
            ->paginate(5);

        $reportStats = [
            'total' => Report::count(),
            'high' => Report::where('severity', 'high')->count(),
            'medium' => Report::where('severity', 'medium')->count(),
            'low' => Report::where('severity', 'low')->count(),
        ];

        return view('manager.reports.index', compact('reports', 'reportStats'));
    }

    public function show($id): View
    {
        $report = Report::with(['equipment', 'reporter', 'task', 'images'])
            ->findOrFail($id);

        return view('manager.reports.show', compact('report'));
    }
}