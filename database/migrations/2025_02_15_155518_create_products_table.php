<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->text('more_description')->nullable();
            $table->text('text')->nullable();
            $table->decimal('soldePrice', 10, 2)->nullable();
            $table->decimal('regularPrice', 10, 2)->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('weight')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('material')->nullable();
            $table->string('brand')->nullable();
            $table->string('image')->nullable();
            $table->boolean('isAvailable')->default(true);
            $table->boolean('isNewArrival')->default(false);
            $table->boolean('isBestSeller')->default(false);
            $table->boolean('isFeatured')->default(false);
            $table->boolean('isSpecialOffer')->default(false);
            $table->integer('stock')->default(0);
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->boolean('isActive')->default(true);
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
