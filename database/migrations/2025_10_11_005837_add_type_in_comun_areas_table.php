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
        Schema::table('comun_areas', function (Blueprint $table) {
            $table->integer('type')->default(1)->after('name');
        });
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('is_exclusive')->default(0)->after('reference');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comun_areas', function (Blueprint $table) {
            //
        });
    }
};
