<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('project_id')->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('client_installment_id')->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->decimal('due_amount', 20, 2);
            $table->date('due_date');
            $table->decimal('paid', 20, 2);
            $table->date('paid_on');
            $table->integer('out_stand');
            $table->decimal('sur_charge', 20, 2);

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
        Schema::dropIfExists('client_reports');
    }
}
