<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->integer('unit_id')->default('1');
            $table->integer('product_type_id')->default('1');
            $table->string('code',256)->nullable();
            $table->string('name', 100);
            $table->string('barcode',256)->nullable();
            $table->integer('has_limit')->default('1');
            $table->text('note')->nullable();
            $table->foreign('category_id')->references('id')->on('categories'); 
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
        Schema::dropIfExists('products');
    }
}
