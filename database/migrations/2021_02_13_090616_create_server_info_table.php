<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server')->constrained('servers');
            $table->boolean('enabled');
            $table->integer('time');
            $table->integer('temp_proces');
            $table->integer('load_proces');
            $table->integer('temp_hard');
            $table->integer('disc_mem');
            $table->integer('ram');
            $table->integer('speed_cooler');
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
        Schema::dropIfExists('server_info');
    }
}
