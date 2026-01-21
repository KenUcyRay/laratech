<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportImage;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function pdf(Report $report)
    {
        try {
            $report->load(['equipment', 'user', 'images']);
            
            // Debug: Log untuk memastikan data ada
            \Log::info('PDF Generation - Report ID: ' . $report->id);
            \Log::info('PDF Generation - Equipment: ' . ($report->equipment->name ?? 'N/A'));
            
            $pdf = Pdf::loadView('operator.reports.pdf-single', compact('report'));
            $pdf->setPaper('A4', 'portrait');
            
            $filename = 'laporan-kerusakan-' . $report->id . '.pdf';
            
            // Gunakan method download langsung
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengunduh PDF: ' . $e->getMessage());
        }
    }

    public function index()
    {
        // Semua laporan
        $allReports = Report::with(['images', 'user', 'equipment'])
            ->whereNotIn('status', ['resolved'])
            ->latest()
            ->paginate(10, ['*'], 'all_page');

        // Laporan Saya
        $myReports = Report::with(['images', 'user', 'equipment'])
            ->whereNotIn('status', ['resolved'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10, ['*'], 'my_page');

        // exclude (pending/processing)
        $activeReportEquipmentIds = Report::whereIn('status', ['pending', 'processing'])
            ->pluck('equipment_id')
            ->toArray();

        $equipments = Equipment::whereNotIn('id', $activeReportEquipmentIds)->get();

        return view('operator.reports.index', compact('allReports', 'myReports', 'equipments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'description' => 'required|string',
            'severity' => 'required|in:low,medium,high',
            'photos.*' => 'image|max:2048'
        ]);

        $report = Report::create([
            'equipment_id' => $request->equipment_id,
            'user_id' => Auth::id(),
            'description' => $request->description,
            'severity' => $request->severity,
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('reports', 'public');

                ReportImage::create([
                    'report_id' => $report->id,
                    'image_url' => $path,
                ]);
            }
        }

        return redirect()->route('operator.reports.index')->with('success', 'Laporan berhasil dikirim');
    }

    public function destroy(Report $report)
    {
        // hapus foto dari storage
        foreach ($report->images as $image) {
            Storage::disk('public')->delete($image->image_url);

        }

        // hapus report
        $report->delete();

        return redirect()
            ->route('operator.reports.index')
            ->with('success', 'Laporan berhasil dihapus');
    }
}
