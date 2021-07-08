<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()
                ->constrained()
                ->onDelete('cascade');
            $table->integer('installment_years')->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->integer('sur_charge')->nullable();
            $table->integer('dealer_commission')->nullable();
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
        Schema::dropIfExists('project_plans');
    }
}
