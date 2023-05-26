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
            $table->date('tanggal_bast');
            $table->string('perihal', 100)->nullable();
            $table->string('ttd_menyerahkan', 100);
            $table->string('ttd_penerima', 100)->nullable();

            //FK dari tabel pegawai
            $table->string('yang_menyerahkan', 5);
            $table->foreign('yang_menyerahkan')->references('nip')->on('pegawai');

            //FK dari tabel pegawai
            $table->string('yang_menerima', 5)->nullable();
            $table->foreign('yang_menerima')->references('nip')->on('pegawai');

            //FK dari tabel permintaan
            $table->string('id_permintaan', 30);
            $table->foreign('id_permintaan')->references('id_permintaan')->on('permintaan');

            //FK dari tabel stasiun
            $table->string('id_stasiun', 3);
            $table->foreign('id_stasiun')->references('id_stasiun')->on('stasiun');

            $table->timestamps();
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
