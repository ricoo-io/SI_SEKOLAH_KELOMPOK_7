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
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('id_siswa')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('id_tugas')->constrained('guru_mata_pelajaran')->onDelete('cascade');
            $table->date('date');
            $table->enum('status', ['H', 'S', 'I', 'A']); // Present, Sick, Excused, Absent
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
