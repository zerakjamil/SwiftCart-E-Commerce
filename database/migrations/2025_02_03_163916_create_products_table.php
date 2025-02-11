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
    {Schema::create('products', function (Blueprint $table) {
        $table->id();

        $table->string('name', 255);
        $table->string('slug', 191)->unique();
        $table->string('SKU', 50)->unique();
        $table->text('description');
        $table->string('short_description', 500)->nullable();

        $table->decimal('regular_price', 8, 2)->index();
        $table->decimal('sale_price', 8, 2)->nullable()->index();

        $table->enum('stock_status', ['instock', 'outofstock'])->index();
        $table->unsignedInteger('quantity')->default(10);

        $table->string('image', 2048)->nullable();
        $table->json('images')->nullable();

        $table->foreignId('category_id')->nullable()
            ->constrained('categories')->onDelete('cascade');
        $table->foreignId('brand_id')->nullable()
            ->constrained('brands')->onDelete('cascade');

        $table->boolean('featured')->default(false)->index();
        $table->timestamps();

        $table->index(['regular_price', 'sale_price']);
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
