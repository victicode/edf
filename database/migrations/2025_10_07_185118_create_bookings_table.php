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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->nulleable()->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('comun_area_id');
            $table->foreign('comun_area_id')->nulleable()->references('id')->on('comun_areas')->onDelete('cascade');
            $table->date('date');
            $table->time('time_from');
            $table->time('time_to');
            $table->double('amount');
            $table->longText('vaucher');
            $table->longText('reference');
            $table->longText('note');
            $table->integer('pay_mehtod');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
