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
        Schema::table('bookings', function (Blueprint $table) {
            //
            $table->integer('status')->default(1)->after('note');
            $table->string('booking_number')->after('comun_area_id')->nullable();


        });

        Schema::create('quotas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('booking_id')->nulleable();
            $table->foreign('booking_id')->nulleable()->references('id')->on('bookings')->onDelete('cascade');
            $table->double('amount');
            $table->longText('vaucher');
            $table->longText('reference');            
            $table->longText('pay_id');
            $table->integer('pay_mehtod');
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('booking_id')->nulleable();
            $table->foreign('booking_id')->nulleable()->references('id')->on('bookings')->onDelete('cascade');
            $table->unsignedBigInteger('quota_id')->nulleable();
            $table->foreign('quota_id')->nulleable()->references('id')->on('quotas')->onDelete('cascade');
            $table->double('amount');
            $table->longText('vaucher');
            $table->longText('reference');            
            $table->longText('pay_id');
            $table->integer('pay_mehtod');
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};
