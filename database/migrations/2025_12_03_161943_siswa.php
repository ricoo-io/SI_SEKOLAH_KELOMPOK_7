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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id('id');
            $table->string('nis')->unique();
            $table->string('nama');
            $table->text('alamat');
            $table->string('ibu');
            $table->string('ayah');
            $table->string('wali');
            $table->string('kontak_wali')->nullable();
            $table->enum('status', ['aktif', 'lulus','non-aktif'])->default('aktif');
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
