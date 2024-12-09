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
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableArray = json_decode(json_encode($table), true);
            $tableName = reset($tableArray);

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
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableArray = json_decode(json_encode($table), true);
            $tableName = reset($tableArray);

            if (Schema::hasColumn($tableName, 'is_enabled')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('is_enabled');
                });
            }
        }
    }
};