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
        Schema::create('bast', function (Blueprint $table) {
            $table->increments('id_bast');
            $table->date('tanggal_bast')->nullable();
            $table->string('nama_barang', 50)->nullable();
            $table->integer('jumlah')->nullable();
            $table->string('perihal', 100)->nullable();            
            $table->unsignedInteger('id_permintaan');
            $table->string('id_stasiun', 3)->nullable();
            
            $table->string('yang_menerima', 5)->nullable();
            $table->string('ttd_penerima', 255)->nullable();
            $table->string('yang_menyerahkan', 5)->nullable();
            $table->string('ttd_menyerahkan', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_permintaan')->references('id_permintaan')->on('permintaan');
            $table->foreign('id_stasiun')->references('id_stasiun')->on('stasiun');
            $table->foreign('yang_menerima')->references('nip')->on('pegawai');
            $table->foreign('yang_menyerahkan')->references('nip')->on('pegawai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bast');
    }
};
