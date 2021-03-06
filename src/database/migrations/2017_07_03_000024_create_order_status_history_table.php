<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatusHistoryTable extends Migration
{
    /**
     * Run the migrations.
     * @table order_status_history
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_status_history', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->id();
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('status_id')->unsigned();
            $table->nullableTimestamps();

            $table->unsignedBigInteger('status_id')->references('id')->on('order_statuses')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('order_id')->references('id')->on('orders')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists('order_status_history');
     }
}
