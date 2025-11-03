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
            Schema::create('quotas', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('departament_id');
                $table->foreign('departament_id')->references('id')->on('departaments')->onDelete('cascade');
                $table->double('amount');
                $table->date('due_date');
                $table->integer('type');
                $table->longText('description');
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
                $table->longText('vaucher')->nullable();
                $table->longText('reference');
                $table->longText('pay_id');
                $table->integer('pay_method');
                $table->integer('status')->default(1);
                $table->timestamps();
                $table->softDeletes();
            });
            $table->unsignedBigInteger('pay_id')->nullable()->after('note');
            $table->foreign('pay_id')->nullable()->references('id')->on('pays')->onDelete('cascade');
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
