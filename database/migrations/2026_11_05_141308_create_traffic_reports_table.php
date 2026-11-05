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
        Schema::create('traffic_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nama_pelapor');
            $table->string('lokasi_jalan');
            $table->integer('tingkat_kepadatan'); // 0-100%
            $table->text('keterangan')->nullable();
            $table->string('status')->default('Menunggu'); // Menunggu, Diproses, Selesai
            $table->string('foto_bukti'); // Path file bukti kondisi jalan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traffic_reports');
    }
};
