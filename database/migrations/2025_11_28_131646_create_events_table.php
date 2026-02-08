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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longtext('description');
            $table->date('date');
            $table->time('time_from');
            $table->time('time_to');
            $table->longText('location')->nullable();
            $table->longText('assits')->default('[]');
            $table->longText('not_assits')->default('[]');
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->foreign('booking_id')->nulleable()->references('id')->on('bookings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
