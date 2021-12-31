<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_classes', function (Blueprint $table) {
            $table->id();
            $table->string('zoom_uuid');
            $table->unsignedBigInteger('zoom_meeting_id');
            $table->string('topic');
            $table->smallInteger('type')->nullable();
            $table->foreignId('section_id')->constrained();
            $table->integer('duration')->nullable();
            $table->text('start_url');
            $table->text('join_url');
            $table->string('password');
            $table->string('start_time');
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
        Schema::dropIfExists('e_classes');
    }
}
