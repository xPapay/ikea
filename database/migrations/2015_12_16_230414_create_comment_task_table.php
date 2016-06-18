<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_task', function (Blueprint $table) {
            $table->integer('comment_id')->unsigned();
            $table->integer('task_id')->unsigned();

            $table->primary('comment_id');
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comment_task');
    }
}
