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
        
        DB::query('UPDATE `task_user` JOIN `tasks` ON `task_user.task_id`=`tasks.id` SET `task_user.accomplish_date` = (SELECT `accomplish_date` FROM `tasks` WHERE `tasks.id` = `task_user.task_id`), 
            `task_user.confirmed` = (SELECT `confirmed` FROM `tasks` WHERE `tasks.id` = `task_user.task_id`);');
        
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
