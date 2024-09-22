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
        Schema::create('hasil_pemeriksaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('dokter_id')->constrained('dokter');
            $table->foreignUuid('pasien_id')->constrained('pasien');
            $table->foreignId('apoteker_id')->nullable()->constrained('apoteker');
            $table->datetime('tgl_pemeriksaan');
            $table->json('tanda_vital');
            $table->text('hasil_pemeriksaan');
            $table->text('resep');
            $table->string('berkas')->nullable();
            $table->tinyInteger('status')->default(App\Enum\ResepStatus::BARU);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_pemeriksaan');
    }
};
