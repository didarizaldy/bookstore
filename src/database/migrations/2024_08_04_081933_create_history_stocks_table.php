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
        Schema::create('history_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_product');
            $table->unsignedBigInteger('id_checkout')->nullable();
            $table->string('id_transaction', 22)->nullable(); // PAY (Sales), IN (Masuk), DSP (Display)
            $table->integer('quantity');
            $table->enum('from', ['sales', 'in', 'display']);
            $table->string('user_from', 120)->nullable();
            $table->timestamp('log_at');
            $table->string('created_by', 120);
            $table->string('updated_by', 120)->nullable();
            $table->timestamps();

            $table->foreign('id_product')->references('id')->on('products');
            $table->foreign('id_checkout')->references('id')->on('checkouts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_stocks');
    }
};
