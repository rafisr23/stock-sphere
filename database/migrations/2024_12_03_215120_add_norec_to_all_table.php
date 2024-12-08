<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $columns = 'Tables_in_' . env('DB_DATABASE');
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableName = $table->$columns;

            if (!Schema::hasColumn($tableName, 'norec')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->string('norec')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $columns = 'Tables_in_' . env('DB_DATABASE');
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableName = $table->$columns;

            if (Schema::hasColumn($tableName, 'norec')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('norec');
                });
            }
        }
    }
};