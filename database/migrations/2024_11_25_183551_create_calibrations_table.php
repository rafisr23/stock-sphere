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
        Schema::create('calibrations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('room_id')->unsigned();
            $table->bigInteger('item_room_id')->unsigned();
            $table->string('remarks')->nullable();
            $table->integer('status')->default(5)->comment('0 - Pending, 1 - Worked on, 2 - Work On Delay, 3 - Completed, 4 - Need Repair, 5 - Pending Room, 6 - Accepted by Room, 7 - Reschedule');
            $table->string('evidence')->nullable();
            $table->date('schedule_by_room')->nullable();
            $table->timestamp('date_worked_on')->nullable();
            $table->timestamp('date_completed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calibrations');
    }
};
