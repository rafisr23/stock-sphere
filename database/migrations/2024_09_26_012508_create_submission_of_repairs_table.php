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
        Schema::create('submission_of_repairs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('unit_id')->unsigned();
            $table->integer('status')->default(0)->description('0 - Pending, 1 - Worked on, 2 - Work On Delay, 3 - Completed, 4 - Cancelled');
            $table->string('description')->nullable();
            $table->timestamp('date_submitted')->useCurrent();
            $table->timestamp('date_worked_on')->nullable();
            $table->timestamp('estimated_date_completed')->nullable();
            $table->timestamp('date_completed')->nullable();
            $table->timestamp('date_cancelled')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_of_repairs');
    }
};