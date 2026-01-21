<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isMekanik();
    }

    public function rules(): array
    {
        return [
            'status' => 'nullable|in:pending,processing,resolved',
            'action' => 'nullable|string|in:assign_task',
            'task_title' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'Status harus berupa pending, processing, atau resolved.',
            'action.in' => 'Action tidak valid.',
            'task_title.max' => 'Judul task maksimal 255 karakter.',
            'notes.max' => 'Catatan maksimal 1000 karakter.',
        ];
    }
}