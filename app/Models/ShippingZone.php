<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingZone extends Model
{
    protected $fillable = [
        'store_id', 'name', 'governorates', 'rate',
        'free_above', 'estimated_days', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'governorates' => 'array',
            'rate'         => 'decimal:2',
            'free_above'   => 'decimal:2',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
