<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('cnic');

            $table->foreignId('project_plan_id')->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->decimal('total_amount', 20, 2)->nullable();
            $table->decimal('down_payment', 20, 2)->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('monthly_installments', 20, 2)->nullable();
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
        Schema::dropIfExists('clients');
    }
}
