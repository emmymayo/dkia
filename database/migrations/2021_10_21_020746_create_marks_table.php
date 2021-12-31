<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('section_id')->constrained();
            $table->foreignId('subject_id')->constrained();
            $table->decimal('cass1',4,1)->default('0');
            $table->decimal('cass2',4,1)->default('0');
            $table->decimal('cass3',4,1)->default('0');
            $table->decimal('cass4',4,1)->default('0');
            $table->decimal('tass',4,1)->default('0');
           
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
        Schema::dropIfExists('marks');
    }
}
