<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('project_id')->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->decimal('due_amount', 10, 2);
            $table->date('due_date');
            $table->decimal('paid', 10, 2);
            $table->date('paid_on');
            $table->integer('ds_dd_no');
            $table->integer('out_stand');
            $table->decimal('sur_charge', 10, 2);

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
