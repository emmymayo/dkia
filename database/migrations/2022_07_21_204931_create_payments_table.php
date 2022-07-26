<?php

use App\Models\Payment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('on_behalf')->nullable();
            $table->string('purpose');
            $table->decimal('amount', $precision = 10, $scale = 2);
            $table->string('reference');
            $table->timestamps('payment_date');
            $table->tinyInteger('payment_service');
            $table->enum('payment_status', [Payment::STATUS_PENDING, Payment::STATUS_PROCCESSING, Payment::STATUS_SUCCESSFUL, Payment::STATUS_FAILED]);
            $table->string('transaction_id');
            $table->string('remark');
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
        Schema::dropIfExists('payments');
    }
}
