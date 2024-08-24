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
        Schema::create('paids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_shipping');
            $table->string('id_payment', 22)->unique(); //PAY20240726211220123 ID Dari keselurahan checkout
            $table->integer('total_item');
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->string('payment', 70); //bank, cod, pickup order
            $table->unsignedBigInteger('id_bankaccount')->nullable();
            $table->decimal('total_fee_shipping', 10, 2)->nullable();
            $table->decimal('total_fee_package', 10, 2)->nullable();
            $table->decimal('total_price_item', 14, 2)->nullable();
            $table->decimal('total_pay', 14, 2)->nullable();
            $table->string('paid_name', 70)->nullable(); //nama pengirim
            $table->string('paid_code_bank', 10)->nullable(); //kode bank
            $table->string('paid_number_bank', 20)->nullable(); //rekening bank
            $table->string('paid_proof_link', 50)->nullable(); //link bukti transfer
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_bankaccount')->references('id')->on('bank_accounts');
            $table->foreign('id_shipping')->references('id')->on('shippings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paids');
    }
};
