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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('event_date')->comment('Tanggal pelaksanaan');
            $table->time('start_time')->comment('Waktu mulai');
            $table->time('end_time')->comment('Waktu selesai');
            $table->string('location')->comment('Lokasi kegiatan');
            $table->enum('status', ['upcoming', 'ongoing', 'completed'])->default('upcoming')
                ->comment('upcoming=Akan Datang, ongoing=Sedang Berlangsung, completed=Selesai');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade')
                ->comment('Admin yang membuat kegiatan');
            $table->timestamps();

            // Indexes untuk optimasi query
            $table->index(['event_date', 'status']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
