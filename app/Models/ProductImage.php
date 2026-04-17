<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_id', 'url', 'alt_text_ar', 'sort_order', 'is_primary',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
