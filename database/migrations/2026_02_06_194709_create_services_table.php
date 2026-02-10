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
        Schema::create('services_vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('document');
            $table->integer('status');
            $table->integer('type');
            $table->timestamps();
        });
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->integer('status');
            $table->integer('type');
            $table->integer('is_favorite')->nullable();
            $table->unsignedBigInteger('services_vendor_id');
            $table->foreign('services_vendor_id')->nulleable()->references('id')->on('services_vendors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
