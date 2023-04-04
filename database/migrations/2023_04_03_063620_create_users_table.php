<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');

            // tambahan untuk role id ditable role
            $table->unsignedBigInteger('id_role');
            $table->foreign('id_role')
            ->references('id_role')
            ->on('roles')
            ->onDelete('cascade')
            ->onUpdate('cascade');

              // tambahan untuk role id ditable role
              $table->string('nip', 5);
              $table->foreign('nip')
              ->references('nip')
              ->on('pegawai')
              ->onDelete('cascade')
              ->onUpdate('cascade');

            // $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
