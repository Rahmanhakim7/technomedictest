<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Examination extends Model
{
    protected $fillable = [
        'registration_id',
        'complaint',
        'systolic',
        'diastolic',
        'pulse',
        'temperature',
        'respiratory_rate',
        'weight',
        'height',
        'examined_at',
        'examiner_name',
    ];

    protected function casts(): array
    {
        return [
            'temperature' => 'decimal:1',
            'weight' => 'decimal:2',
            'height' => 'decimal:2',
            'examined_at' => 'datetime',
        ];
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}
