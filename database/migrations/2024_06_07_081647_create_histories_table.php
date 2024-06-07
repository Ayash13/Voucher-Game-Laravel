<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id('id_history');
            $table->foreignId('id_pembayaran')->constrained('payments', 'id_pembayaran');
            $table->foreignId('id_user')->constrained('users', 'id_user');
            $table->foreignId('id_product')->constrained('products', 'id_product');
            $table->integer('amount');
            $table->timestamps();

            $table->unique(['id_user', 'id_product', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('histories');
    }
}
