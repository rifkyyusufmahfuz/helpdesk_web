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
        Schema::create('tindak_lanjut_hardware', function (Blueprint $table) {
            $table->increments('id_executor');
            $table->date('tanggal_penanganan');
            $table->string('ttd_executor', 100)->nullable();
            $table->unsignedInteger('id_permintaan');
            $table->unsignedInteger('id');
            $table->timestamps();

            $table->foreign('id_permintaan')
                  ->references('id')
                  ->on('permintaan')
                  ->onDelete('cascade');

            $table->foreign('id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tindak_lanjut_hardware');
    }
};
