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
        Schema::create('waste_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('waste_type_id')->constrained()->cascadeOnDelete();
            $table->decimal('weight', 10, 2)->comment('Berat dalam kg');
            $table->decimal('price_per_kg', 12, 2)->comment('Harga per kg saat setoran');
            $table->decimal('total_amount', 15, 2)->comment('Total nilai = weight * price_per_kg');
            $table->date('deposit_date');
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_deposits');
    }
};
