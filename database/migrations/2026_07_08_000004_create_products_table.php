<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('sku', 50)->unique();
            $table->text('description')->nullable();
            $table->decimal('cost_price', 15, 2)->default(0); // satuan ribuan: 50 = Rp 50.000, 0.5 = Rp 500
            $table->decimal('sell_price', 15, 2)->default(0); // satuan ribuan: 50 = Rp 50.000, 0.5 = Rp 500
            $table->integer('quantity')->default(0);
            $table->integer('min_stock')->default(5);
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['branch_id', 'is_active']);
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
