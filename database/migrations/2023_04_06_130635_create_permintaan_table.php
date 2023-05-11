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
            $table->enum('tipe_permintaan', ['hardware', 'software']);
            $table->enum('status_permintaan', ['1', '2', '3', '4', '5', '6', '7']);
            // 1 = belum diproses (status pending warna merah)
            // 2 = sedang diajukan ke manager (status pending warna kuning)
            // 3 = Serahkan PC/Laptop ke NOC (status permintaan diterima warna hijau)
            // 4 = barang diterima (status Diproses warna biru) ,
            // 5 = barang siap diambil (status selesai warna kuning)
            // 6 = barang sudah dikembalikan (status selesai warna hijau)
            // 7 = permintaan ditolak manager (status selesai warna merah)

            $table->date('tanggal_permintaan');
            $table->string('ttd_requestor', 100);

            //FK Kolom kode_barang dari table barang
            $table->string('kode_barang', 20);
            $table->foreign('kode_barang')->references('kode_barang')->on('barang')->onDelete('cascade');

            //FK Kolom id dari table users
            $table->unsignedInteger('id');
            $table->foreign('id')->references('id')->on('users');

            //FK Kolom id_otorisasi dari table otorisasi
            $table->unsignedInteger('id_otorisasi');
            $table->foreign('id_otorisasi')->references('id_otorisasi')->on('otorisasi')->onDelete('cascade');

            //FK Kolom id_kategori dari table kategori_software
            $table->unsignedInteger('id_kategori');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_software')->onDelete('cascade');

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
