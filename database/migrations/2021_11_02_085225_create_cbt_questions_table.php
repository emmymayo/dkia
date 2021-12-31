<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCbtQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cbt_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cbt_id')->constrained()->onDelete('cascade');
            $table->text('question');
            $table->mediumText('instruction')->nullable();
            $table->smallInteger('marks')->default(1);
            $table->tinyInteger('type')->default(1);
            $table->string('image')->nullable();
            $table->boolean('bonus')->default(false);
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
        Schema::dropIfExists('cbt_questions');
    }
}
