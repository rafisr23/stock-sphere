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
        Schema::table('items_units', function (Blueprint $table) {
            $table->timestamp('installation_date')->nullable()->change();
            $table->timestamp('end_of_service')->nullable()->change();
            $table->timestamp('last_checked_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items_units', function (Blueprint $table) {
            //
        });
    }
};