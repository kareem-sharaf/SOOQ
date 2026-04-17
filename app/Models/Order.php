<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'store_id', 'customer_id', 'order_number', 'status',
        'payment_status', 'payment_method', 'subtotal', 'shipping_cost',
        'discount_amount', 'tax_amount', 'total', 'shipping_address',
        'notes_customer', 'notes_internal',
    ];

    protected function casts(): array
    {
        return [
            'shipping_address' => 'array',
            'subtotal'         => 'decimal:2',
            'shipping_cost'    => 'decimal:2',
            'discount_amount'  => 'decimal:2',
            'tax_amount'       => 'decimal:2',
            'total'            => 'decimal:2',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }
}
