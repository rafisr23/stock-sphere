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
        Schema::create('new_logs', function (Blueprint $table) {
            $table->id();
            $table->string('norec')->nullable()->unique();
            $table->string('norec_parent')->nullable();
            $table->bigInteger('module_id')->nullable();
            $table->boolean('is_repair')->nullable()->default(false);
            $table->boolean('is_maintenance')->nullable()->default(false);
            $table->boolean('is_generic')->nullable()->default(false);
            $table->text('desc')->nullable();
            $table->string('ip')->nullable();
            $table->unsignedBigInteger('item_unit_id')->nullable();
            $table->unsignedBigInteger('technician_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_logs');
    }
};