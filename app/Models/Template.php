<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'name_ar', 'name_en', 'slug', 'category',
        'description_ar', 'description_en', 'thumbnail',
        'store_config', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'store_config' => 'array',
        ];
    }
}
