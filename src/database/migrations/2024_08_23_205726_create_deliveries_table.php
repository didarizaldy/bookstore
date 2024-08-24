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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('id_payment', 22)->unique(); //PAY20240726211220123 ID Dari keselurahan checkout
            $table->string('receiver_name', 50);
            $table->string('receiver_address', 200)->nullable();
            $table->string('receiver_phone', 15);
            $table->string('type', 50); //pick-up-delivery, cash-on-delivery, logistic
            $table->string('status', 50); //menunggu konfirmasi, diproses, dikirim, diterima, dibatalkan, ditolak
            $table->string('connote', 50)->nullable(); //no resi xxxxxxx
            $table->string('logistic', 50)->nullable(); //jasa kirim xxxxxxxx
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
