<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected static function booted()
    {
        static::deleting(function ($equipment) {
            // Cascade delete relations
            $equipment->tasks()->each(fn($task) => $task->delete());
            $equipment->maintenances()->each(fn($maintenance) => $maintenance->delete());
            $equipment->reports()->each(fn($report) => $report->delete());
            $equipment->images()->each(fn($image) => $image->delete());
        });
    }

    protected $table = 'equipments';

    protected $fillable = [
        'code',
        'name',
        'equipment_type_id',
        'status',
        'hour_meter',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(EquipmentImage::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
