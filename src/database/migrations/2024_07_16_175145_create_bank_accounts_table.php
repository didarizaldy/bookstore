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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank_code', 3);
            $table->string('bank_name', 50);
            $table->string('account_name', 120);
            $table->string('account_code', 40)->unique();
            $table->enum('active', [1, 0])->default(1);
            $table->string('created_by', 120);
            $table->string('updated_by', 120)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
