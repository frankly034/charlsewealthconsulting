<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_text');
            $table->text('description_text');
            $table->bigInteger('id_eventbrite')->unique();
            $table->string('url');
            $table->dateTime('start_local');
            $table->dateTime('end_local');
            $table->integer('created');
            $table->integer('changed');
            $table->integer('capacity');
            $table->string('status');
            $table->boolean('is_free');
            $table->text('logo_url');
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
        Schema::dropIfExists('events');
    }
}
