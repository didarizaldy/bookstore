<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_shipping');
            $table->string('invoice'); //INV/20240710/0430020
            $table->string('id_payment', 22); //PAY20240726211220123 Harus sama nanti untuk setiap barang
            $table->unsignedBigInteger('id_product');
            $table->integer('quantity');
            $table->decimal('original_price', 10, 2);
            $table->decimal('display_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->decimal('fee_shipping', 10, 2)->nullable();
            $table->decimal('fee_package', 10, 2)->nullable();
            $table->decimal('discount_shipping', 10, 2)->nullable();
            $table->decimal('discount_package', 10, 2)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_product')->references('id')->on('products');
            $table->foreign('id_shipping')->references('id')->on('shippings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
