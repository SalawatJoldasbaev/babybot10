<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Baby extends Model
{
    protected $fillable = [
        'name',
        'birthday',
        'patient_id'
    ];

    protected function casts(): array
    {
        return [
            'birthday' => 'date',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
