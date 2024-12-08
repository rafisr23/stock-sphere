<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

            if (!Schema::hasColumn($tableName, 'is_enabled')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->boolean('is_enabled')->nullable()->default(true);
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

            if (Schema::hasColumn($tableName, 'is_enabled')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('is_enabled');
                });
            }
        }
    }
};