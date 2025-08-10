<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->text('description_ar');
            $table->text('description_en');
            $table->string('currency');
            $table->decimal('exchange_rate', 8, 4);
            $table->integer('min_daily_budget');
            $table->integer('max_daily_budget');
            $table->string('image_url');
            $table->string('badge_type')->nullable(); // شعبية، ممتازة للعائلات، اقتصادية
            $table->string('badge_text_ar')->nullable();
            $table->string('badge_text_en')->nullable();
            $table->boolean('is_popular')->default(false);
            $table->json('best_months')->nullable(); // أفضل الشهور للسفر
            $table->json('weather_types')->nullable(); // أنواع الطقس
            $table->json('trip_types')->nullable(); // أنواع الرحلات المناسبة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};