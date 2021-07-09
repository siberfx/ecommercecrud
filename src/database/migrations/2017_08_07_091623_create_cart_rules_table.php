<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartRulesTable extends Migration
{
    /**
     * Run the migrations.
     * @table user_rules
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_rules', function(Blueprint $table) {
			$table->id();
            $table->string('name', 255);
            $table->string('code', 100);
            $table->tinyInteger('priority');
            $table->dateTime('start_date');
            $table->dateTime('expiration_date');
            $table->boolean('status')->default(0);
            $table->boolean('highlight')->default(0);
            $table->integer('minimum_amount')->nullable()->default(0);
            $table->boolean('free_delivery')->default(0);
            $table->integer('total_available')->nullable();
            $table->integer('total_available_each_user')->nullable();
            $table->string('promo_label', 255)->nullable();
            $table->string('promo_text', 1000)->nullable();
            $table->integer('multiply_gift')->nullable()->default(1);
            $table->integer('min_nr_products')->nullable()->default(0);
            $table->enum('discount_type', ['Percent - order', 'Percent - selected products', 'Percent - cheapest product', 'Percent - most expensive product', 'Amount - order']);
            $table->decimal('reduction_amount', 13, 2)->nullable()->default(0);
            $table->bigInteger('reduction_currency_id')->unsigned()->nullable();
            $table->bigInteger('minimum_amount_currency_id')->unsigned()->nullable();
            $table->bigInteger('gift_product_id')->unsigned()->nullable();
			$table->bigInteger('customer_id')->unsigned()->nullable();
			$table->nullableTimestamps();

            $table->unsignedBigInteger('customer_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('gift_product_id')->references('id')->on('products')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('reduction_currency_id')->references('id')->on('currencies')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('minimum_amount_currency_id')->references('id')->on('currencies')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_rules');
    }
}
