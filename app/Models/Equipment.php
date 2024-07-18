<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'equipmentID',
        'description',
        'user_id',
        'equipment_status_id',
        'allocation_status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function equipmentStatus(): BelongsTo
    {
        return $this->belongsTo(EquipmentStatus::class);
    }

    public function allocation(): HasOne
    {
        return $this->hasOne(Allocation::class);
    }
}
