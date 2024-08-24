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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 22)->unique();
            $table->unsignedBigInteger('id_category');
            $table->string('title', 180);
            $table->string('slug', 180)->unique();
            $table->string('filename_img', 180)->nullable()->unique();
            $table->string('author', 120)->nullable();
            $table->string('publisher', 120)->nullable();
            $table->decimal('original_price', 8, 2);
            $table->decimal('display_price', 8, 2);
            $table->float('discount', 2, 2);
            $table->integer('pages');
            $table->date('release_at');
            $table->string('isbn', 50)->nullable()->unique();
            $table->string('lang', 30);
            $table->integer('stocks');
            $table->boolean('available')->default(1);
            $table->string('created_by', 120);
            $table->string('updated_by', 120)->nullable();
            $table->timestamps();

            $table->foreign('id_category')->references('id')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
