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
        Schema::create('items_units', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('item_id')->constrained('items');
            // $table->foreignId('unit_id')->constrained('units');
            $table->bigInteger('item_id');
            $table->bigInteger('unit_id');
            $table->string('serial_number');
            $table->string('software_version');
            $table->string('installation_date');
            $table->string('contract');
            $table->string('end_of_service');
            $table->string('srs_status');
            $table->enum('status', ['Running', 'System Down', 'Restricted']);
            $table->string('last_checked_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_units');
    }
};
