<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->boolean('notify_task_assigned')->default(true);
            $table->boolean('notify_task_edited')->default(true);
            $table->boolean('notify_task_accomplished')->default(true);
            $table->boolean('notify_task_accepted')->default(true);
            $table->boolean('notify_task_rejected')->default(true);
            $table->boolean('notify_comment_added')->default(true);
            $table->time('no_interruption_from')->nullable()->default(null);
            $table->time('no_interruption_to')->nullable()->default(null);

            $table->primary('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings');
    }
}
