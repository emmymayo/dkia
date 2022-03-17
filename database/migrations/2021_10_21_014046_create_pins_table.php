<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_pins', function (Blueprint $table) {
            $table->id();
            
            $table->string('token');
            $table->foreignId('exam_id')->constrained();
            $table->bigInteger('student_id')->nullable();
            $table->string('serial_no')->nullable();
            $table->integer('units_left')->default(100);
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
        Schema::dropIfExists('exam_pins');
    }
}
