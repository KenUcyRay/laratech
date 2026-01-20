<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Maintenance extends Model
{
    use HasUuids;

    protected $fillable = [
        'equipment_id',
        'user_id',
        'last_service_date',
        'next_service_due',
    ];

    protected $casts = [
        'last_service_date' => 'datetime',
        'next_service_due' => 'datetime',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
