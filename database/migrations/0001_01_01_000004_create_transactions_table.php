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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment('Admin yang input');
            $table->enum('type', ['income', 'expense'])->comment('income=Pemasukan, expense=Pengeluaran');
            $table->decimal('amount', 15, 2)->comment('Nominal transaksi');
            $table->text('description')->comment('Keterangan transaksi');
            $table->date('transaction_date')->comment('Tanggal transaksi dilakukan');
            $table->timestamps();

            // Indexes untuk optimasi query
            $table->index(['category_id', 'transaction_date']);
            $table->index(['type', 'transaction_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
