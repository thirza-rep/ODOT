<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // kasir
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->string('invoice_number', 30)->unique();
            $table->decimal('subtotal', 15, 2)->default(0);      // satuan ribuan
            $table->decimal('discount', 15, 2)->default(0);       // satuan ribuan
            $table->decimal('tax', 15, 2)->default(0);            // satuan ribuan
            $table->decimal('total', 15, 2)->default(0);          // satuan ribuan
            $table->decimal('amount_paid', 15, 2)->default(0);    // satuan ribuan
            $table->decimal('change_amount', 15, 2)->default(0);  // satuan ribuan
            $table->enum('payment_method', ['cash', 'transfer', 'qris', 'ewallet'])->default('cash');
            $table->enum('status', ['completed', 'pending', 'cancelled'])->default('completed');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['branch_id', 'created_at']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
