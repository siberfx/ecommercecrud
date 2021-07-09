<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeProductValueTable extends Migration
{
    /**
     * Run the migrations.
     * @table attribute_product_value
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_product_value', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('attribute_id')->unsigned();
            $table->string('value', 255)->nullable()->default(null);

            $table->unsignedBigInteger('attribute_id')->references('id')->on('attributes')->onDelete('no action')->onUpdate('no action');
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
       Schema::dropIfExists('attribute_product_value');
     }
}
