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
        Schema::create('spareparts_of_repairs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sparepart_id')->unsigned();
            $table->bigInteger('details_of_repair_submission_id')->unsigned();
            $table->string('description')->nullable();
            $table->string('operational_state')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spareparts_of_repairs');
    }
};
