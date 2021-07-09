<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartRulesCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_rules_customers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('cart_rule_id')->unsigned();
			$table->bigInteger('customer_id')->unsigned();
			$table->nullableTimestamps();
			
            $table->unsignedBigInteger('cart_rule_id')->references('id')->on('cart_rules')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('customer_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_rules_customers');
    }
}
