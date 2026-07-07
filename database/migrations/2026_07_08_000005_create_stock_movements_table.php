<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['in', 'out', 'adjustment']);
            $table->integer('quantity'); // positif = masuk, negatif = keluar
            $table->integer('quantity_before');
            $table->integer('quantity_after');
            $table->string('reference')->nullable(); // No. referensi / PO / Invoice
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'created_at']);
            $table->index(['branch_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
