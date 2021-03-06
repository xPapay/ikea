<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveColumnsAccomplishDateAndConfirmedFromTasksToTaskUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_user', function (Blueprint $table) {
            $table->timestamp('accomplish_date')->nullable()->default(null);
            $table->boolean('confirmed')->default(0);
        });

        \DB::statement('
            UPDATE `task_user`, `tasks`
            SET `task_user`.`accomplish_date` = `tasks`.`accomplish_date`,
                `task_user`.`confirmed` = `tasks`.`confirmed`
            WHERE `task_user`.`task_id` = `tasks`.`id`;
        ');
        
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('accomplish_date');
            $table->dropColumn('confirmed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            //
        });
    }
}
