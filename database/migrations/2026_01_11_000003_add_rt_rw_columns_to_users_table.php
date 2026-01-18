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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('rt_id')->nullable()->after('rejection_reason')->constrained()->nullOnDelete();
            $table->foreignId('rw_id')->nullable()->after('rt_id')->constrained()->nullOnDelete();
            $table->string('nik', 16)->nullable()->unique()->after('email');
            $table->enum('residence_status', ['tetap', 'kontrak', 'kos'])->default('tetap')->after('status');
            $table->string('occupation', 100)->nullable()->after('residence_status');
            $table->decimal('waste_balance', 15, 2)->default(0)->after('occupation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['rt_id']);
            $table->dropForeign(['rw_id']);
            $table->dropColumn(['rt_id', 'rw_id', 'nik', 'residence_status', 'occupation', 'waste_balance']);
        });
    }
};
