<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEmployeeIdFromTasks extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('employee_id');
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('employee_id')->nullable()->constrained('employees');
        });
    }
}
