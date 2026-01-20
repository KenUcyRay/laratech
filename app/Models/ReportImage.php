<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportImage extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'report_id',
        'image_url',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
