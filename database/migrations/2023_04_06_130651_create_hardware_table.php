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
        Schema::create('hardware', function (Blueprint $table) {
            $table->increments('id_hardware');
            $table->string('komponen', 50);
            $table->enum('status_hardware', ['OK', 'NOK']);
            $table->string('problem', 100);
            $table->unsignedInteger('id_permintaan');
            $table->foreign('id_permintaan')->references('id_permintaan')->on('permintaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware');
    }
};
