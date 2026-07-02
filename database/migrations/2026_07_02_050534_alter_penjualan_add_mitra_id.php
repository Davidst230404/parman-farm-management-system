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
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropColumn('mitra');
            $table->foreignId('mitra_id')->after('id')->constrained('mitras')->onDelete('cascade');
            $table->string('metode')->default('Transfer Bank');
            $table->string('status')->default('Selesai');
            $table->text('catatan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropForeign(['mitra_id']);
            $table->dropColumn(['mitra_id', 'metode', 'status', 'catatan']);
            $table->string('mitra')->default('Greenfields')->after('total_pendapatan');
        });
    }
};
