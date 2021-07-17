<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_installments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->date('payment_date');
            $table->decimal('plenty', 20, 2);
            $table->decimal('amount_paid', 20, 2);
            $table->decimal('remaining_amount', 20, 2);
            $table->string('payment_method');
            $table->string('cheque_draft_no');
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
        Schema::dropIfExists('client_installments');
    }
}
