<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportImage;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
  public function pdf(Report $report)
    {
        $report->load(['equipment', 'user', 'images']);

        $pdf = Pdf::loadView('operator.reports.pdf-single', compact('report'));

        return $pdf->download(
            'laporan-kerusakan-' . $report->id . '.pdf'
        );
    }
    
   public function index()
    {
        $reports = Report::with(['images', 'user', 'equipment'])
            ->latest()
            ->get();

        $equipments = Equipment::all();

        return view('operator.reports.index', compact('reports', 'equipments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'description'  => 'required|string',
            'severity'     => 'required|in:low,medium,high',
            'photos.*'     => 'image|max:2048'
        ]);

        $report = Report::create([
            'equipment_id' => $request->equipment_id,
            'user_id'      => Auth::id(),
            'description'  => $request->description,
            'severity'     => $request->severity,
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

        return redirect() ->route('operator.reports.index') ->with('success', 'Laporan berhasil dikirim');
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
