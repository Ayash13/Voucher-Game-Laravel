<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('id_user')->constrained('users', 'id_user');
            $table->foreignId('id_product')->constrained('products', 'id_product');
            $table->string('method');
            $table->decimal('total', 10, 3);
            $table->string('whatsapp');
            $table->timestamps();

            $table->unique(['created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
