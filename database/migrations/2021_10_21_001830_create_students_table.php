<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('admin_no',40)->nullable();
            $table->year('year_admitted')->nullable();
            $table->boolean('graduated',1)->default(false);
            $table->string('gender',20);
            $table->date('dob');
            $table->foreignId('state_id')->constrained();
            $table->foreignId('lga_id')->constrained();
            $table->text('address')->nullable();
            $table->string('guardian_email')->nullable();
            $table->string('phone1',20)->nullable();
            $table->string('phone2',20)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
