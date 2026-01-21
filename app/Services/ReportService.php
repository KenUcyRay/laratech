<?php

namespace App\Services;

use App\Models\Report;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReportService
{
    public function createTaskFromReport(Report $report, ?string $taskTitle = null, ?string $notes = null): Task
    {
        if ($report->task_id) {
            throw new \Exception('Report sudah memiliki task yang terkait');
        }

        $title = $taskTitle ?? Str::limit($report->description, 50, '...');
        
        $task = Task::create([
            'equipment_id' => $report->equipment_id,
            'title' => $title,
            'description' => $notes ?? 'Auto-generated from report',
            'priority' => $this->mapSeverityToPriority($report->severity),
            'status' => 'todo',
            'assigned_to' => Auth::id(),
            'due_date' => now()->addDays($this->getDueDaysFromSeverity($report->severity)),
        ]);

        $report->update([
            'task_id' => $task->id,
            'status' => 'processing'
        ]);

        return $task;
    }

    public function updateReportStatus(Report $report, string $status): Report
    {
        $validStatuses = ['pending', 'processing', 'resolved'];
        
        if (!in_array($status, $validStatuses)) {
            throw new \InvalidArgumentException('Status tidak valid');
        }

        $report->update(['status' => $status]);
        
        return $report;
    }

    private function mapSeverityToPriority(string $severity): string
    {
        return match($severity) {
            'high' => 'high',
            'medium' => 'medium',
            'low' => 'low',
            default => 'medium'
        };
    }

    private function getDueDaysFromSeverity(string $severity): int
    {
        return match($severity) {
            'high' => 1,
            'medium' => 3,
            'low' => 7,
            default => 3
        };
    }
}