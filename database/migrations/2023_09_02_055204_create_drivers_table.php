<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_drivers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->integer('no');
            $table->integer('transaksi');
            $table->string('nama');
            $table->string('no_tlpn');
            $table->string('nopolisi');
            $table->string('no_stnk');
            $table->string('no_sim');
            $table->string('jenis_mobil');
            $table->string('nama_kepemilikan');
            $table->string('fotokend');
            $table->string('kapasitas');
            $table->string('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
}
