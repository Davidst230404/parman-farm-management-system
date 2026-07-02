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
        Schema::create('kesehatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sapi_id')->constrained('sapi')->onDelete('cascade');
            $table->string('nafsu_makan');
            $table->string('kondisi_susu');
            $table->string('perilaku');
            $table->text('catatan')->nullable();
            $table->string('status')->default('Normal'); // Normal, Perlu Pemantauan, Perlu Tindakan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kesehatan');
    }
};
