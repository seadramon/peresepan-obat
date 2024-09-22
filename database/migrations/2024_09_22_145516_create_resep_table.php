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
        Schema::create('resep', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('hasil_pemeriksaan_id')->constrained('hasil_pemeriksaan')->onDelete('cascade');
            $table->uuid('obat_id')->nullable();
            $table->string('obat')->nullable();
            $table->integer('harga_satuan')->default(0);
            $table->integer('harga')->default(0);
            $table->integer('jumlah')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep');
    }
};
