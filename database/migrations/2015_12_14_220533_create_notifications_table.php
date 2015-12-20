<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', [
                'nová úloha',
                'úloha dokončená',
                'úloha editovaná',
                'nový problém',
                'problém vyriešený',
                'problém editovaný',
                'pridelenie na followup',
                'followup vykonaný',
                'nový komentár',
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notifications');
    }
}
