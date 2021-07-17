<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealerReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealer_reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dealer_id')->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('project_id')->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('dealer_installment_id')->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->decimal('due_amount', 20, 2);
            $table->decimal('paid', 20, 2);
            $table->date('paid_on');
            $table->integer('out_stand');
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
        Schema::dropIfExists('reports');
    }
}
