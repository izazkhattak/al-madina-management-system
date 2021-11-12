<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('due_date');

            $table->foreignId('client_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('project_id')
                ->constrained()
                ->onDelete('cascade');

            $table->decimal('amount_paid', 20, 2)->nullable();
            $table->decimal('remaining_amount', 20, 2)->nullable();
            $table->decimal('total_amount', 20, 2)->nullable();
            $table->decimal('installments', 20, 2)->nullable();
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
        Schema::dropIfExists('schedules');
    }
}
