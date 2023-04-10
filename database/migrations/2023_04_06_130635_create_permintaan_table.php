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
        Schema::create('permintaan', function (Blueprint $table) {
            $table->increments('id_permintaan');
            $table->string('keluhan_kebutuhan');
            $table->string('no_aset', 20);
            $table->enum('tipe_permintaan', ['hardware', 'software']);
            $table->enum('status_permintaan', ['pending', 'proses', 'selesai']);
            $table->date('tanggal_permintaan');
            $table->string('ttd_requestor', 100);

            //FK Kolom id dari table users
            $table->unsignedInteger('id');
            $table->foreign('id')->references('id')->on('users');

            //FK Kolom id_otorisasi dari table otorisasi
            $table->unsignedInteger('id_otorisasi')->nullable();
            $table->foreign('id_otorisasi')->references('id_otorisasi')->on('otorisasi');

            //FK Kolom id_kategori dari table kategori_software
            $table->unsignedInteger('id_kategori')->nullable();
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_software')->onDelete('set null');

            //timestamp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan');
    }
};
