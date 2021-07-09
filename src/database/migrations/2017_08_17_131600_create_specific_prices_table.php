<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecificPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specific_prices', function(Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->id();
            $table->decimal('reduction', 13, 2)->nullable()->default(0);
            $table->enum('discount_type', array('Amount', 'Percent'));
            $table->dateTime('start_date');
            $table->dateTime('expiration_date');
            $table->bigInteger('product_id')->unsigned()->nullable();

            $table->unsignedBigInteger('product_id')->references('id')->on('products')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specific_prices');
    }
}
