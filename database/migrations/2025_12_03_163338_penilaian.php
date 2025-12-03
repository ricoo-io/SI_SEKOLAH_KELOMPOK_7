<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('id_siswa')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('id_mapel')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->foreignId('id_tugas')->constrained('guru_mata_pelajaran')->onDelete('cascade');
            $table->integer('nilai_harian')->nullable();
            $table->integer('nilai_UTS')->nullable();
            $table->integer('nilai_UAS')->nullable();
            $table->integer('nilai_Akhir')->nullable();
            $table->timestamp('update_terakhir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
