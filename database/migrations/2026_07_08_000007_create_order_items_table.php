<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name');      // snapshot nama barang saat transaksi
            $table->string('product_sku', 50);   // snapshot SKU
            $table->decimal('cost_price', 15, 2);  // snapshot harga beli (satuan ribuan)
            $table->decimal('sell_price', 15, 2);  // snapshot harga jual (satuan ribuan)
            $table->integer('quantity');
            $table->decimal('subtotal', 15, 2);    // sell_price * quantity
            $table->timestamps();

            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
