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
        Schema::create('tindak_lanjut', function (Blueprint $table) {
            $table->increments('id_tindak_lanjut');
            $table->date('tanggal_penanganan')->nullable();
            $table->string('ttd_admin', 255);
            $table->unsignedInteger('id');
            $table->unsignedInteger('id_permintaan');

            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_permintaan')->references('id_permintaan')->on('permintaan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tindak_lanjut_software');
    }
};
