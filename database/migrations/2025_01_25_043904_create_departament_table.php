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
        Schema::create('departament', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('address')->nullable();
            $table->string('block')->nullable();
            $table->float('area');
            $table->string('description');
            $table->string('code_pay')->nullable();
            $table->string('floor');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departament');
    }
};
