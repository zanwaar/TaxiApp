<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('payment_id')->unique();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->Uuid('user_driver_id')->nullable();
            $table->string('layanan');
            $table->string('rute');
            $table->string('jumlah_penumpang');
            $table->string('titikkor');
            $table->string('notlpn');
            $table->string('alamat');
            $table->string('status');
            $table->decimal('total_price', 10, 2);
            $table->string('snap_token', 36)->nullable();
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
        Schema::dropIfExists('orders');
    }
}
