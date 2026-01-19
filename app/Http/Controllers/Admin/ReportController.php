<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $reports = Report::with(['equipment.type', 'reporter', 'images'])
            ->latest()
            ->get();

        return view('admin.reports.index', compact('reports'));
    }
}
