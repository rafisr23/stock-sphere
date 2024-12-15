<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('details_of_repair_submissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('submission_of_repair_id')->unsigned();
            $table->bigInteger('item_unit_id')->unsigned();
            $table->bigInteger('technician_id')->unsigned();
            $table->integer('quantity')->default(1);
            $table->integer('status')->default(0)->description('0 - Pending, 1 - Worked on, 2 - Completed, 3 - Cancelled');
            $table->string('remarks')->nullable();
            $table->string('evidence')->nullable();
            $table->string('descriptionTechnician')->nullable();
            $table->timestamp('date_worked_on')->nullable();
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
        Schema::dropIfExists('details_of_repair_submissions');
    }
};