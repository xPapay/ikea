<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->string('solution');
            $table->timestamp('deadline');
            $table->timestamp('followup_date');
            $table->integer('followup_by')->unsigned()->nullable();
            $table->decimal('costs', 8, 2);
            $table->integer('ordered_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('ordered_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('followup_by')->references('id')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('issues');
    }
}
