<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSettingsColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('notify_task_assigned')->default(1);
            $table->boolean('notify_task_unassigned')->default(1);
            $table->boolean('notify_task_edited')->default(1);
            $table->boolean('notify_task_deleted')->default(1);
            $table->boolean('notify_task_accomplished')->default(1);
            $table->boolean('notify_task_accepted')->default(1);
            $table->boolean('notify_task_rejected')->default(1);
            $table->boolean('notify_comment_added')->default(1);
            $table->time('no_interruption_from')->nullable()->default('00:00');
            $table->time('no_interruption_to')->nullable()->default('00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
