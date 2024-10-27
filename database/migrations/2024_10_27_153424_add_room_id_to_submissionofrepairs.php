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
        Schema::table('submission_of_repairs', function (Blueprint $table) {
            $table->bigInteger('room_id')->unsigned()->nullable()->after('unit_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submission_of_repairs', function (Blueprint $table) {
            //
        });
    }
};