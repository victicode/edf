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
        Schema::create('comun_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('capacity');
            $table->double('price')->default(0);
            $table->double('warranty_price')->default(0);
            $table->longText('description')->nullable();
            $table->integer('max_time_reserve')->default(1);
            $table->time('timeFrom');
            $table->time('timeTo');
            $table->longText('rules');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comun_areas');
    }
};
