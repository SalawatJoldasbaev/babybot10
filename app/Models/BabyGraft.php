<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BabyGraft extends Model
{
    protected $fillable = [
        'datetime',
        'description',
        'message_sent',
        'graft_status',
        'baby_id',
        'graft_id'
    ];

    public function baby(): BelongsTo
    {
        return $this->belongsTo(Baby::class);
    }

    public function graft(): BelongsTo
    {
        return $this->belongsTo(Graft::class);
    }

    protected function casts(): array
    {
        return [
            'datetime' => 'datetime',
        ];
    }
}
