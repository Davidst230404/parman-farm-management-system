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
    {
        Schema::create('produksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sapi_id')->constrained('sapi')->onDelete('cascade');
            $table->decimal('jumlah_susu', 8, 2);
            $table->string('sesi'); // pagi, sore
            $table->date('tanggal');
            $table->string('status')->default('Tersimpan'); // Tersimpan, Belum Input
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksi');
    }
};
