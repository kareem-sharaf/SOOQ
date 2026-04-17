<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->string('category'); // FASHION, ELECTRONICS, FOOD, BEAUTY, GENERAL, etc.
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('store_config'); // Full store_config.json
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
