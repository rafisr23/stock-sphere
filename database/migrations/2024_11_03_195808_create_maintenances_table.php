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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('room_id')->unsigned();
            $table->bigInteger('item_room_id')->unsigned();
            $table->bigInteger('technician_id')->unsigned();
            $table->string('remarks')->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(0)->description('0 - Pending, 1 - Worked on, 2 - Work On Delay, 3 - Completed, 4 - Need Repairs');
            $table->string('evidence')->nullable();
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
        Schema::dropIfExists('maintenances');
    }
};
