<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('store_name');
            $table->string('slug')->unique();
            $table->string('store_category');
            $table->string('primary_currency_code')->default('SYP');
            $table->string('theme_code')->default('DEFAULT');
            $table->string('logo')->nullable();
            $table->json('store_config')->nullable();
            $table->enum('status', ['active', 'maintenance', 'paused', 'closed'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
