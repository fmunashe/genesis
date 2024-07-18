<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipmentStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'status'
    ];

    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }
}
