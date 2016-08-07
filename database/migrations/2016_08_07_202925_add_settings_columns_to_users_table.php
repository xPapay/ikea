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
            $table->boolean('notify_task_assigned')->default(true);
            $table->boolean('notify_task_unassigned')->default(true);
            $table->boolean('notify_task_edited')->default(true);
            $table->boolean('notify_task_deleted')->default(true);
            $table->boolean('notify_task_accomplished')->default(true);
            $table->boolean('notify_task_accepted')->default(true);
            $table->boolean('notify_task_rejected')->default(true);
            $table->boolean('notify_comment_added')->default(true);
            $table->time('no_interruption_from')->nullable()->default(null);
            $table->time('no_interruption_to')->nullable()->default(null);
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
