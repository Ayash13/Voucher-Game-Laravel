<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users', 'id_user');
            $table->foreignId('id_product')->constrained('products', 'id_product');
            $table->timestamps();
            $table->unique(['id_user', 'id_product', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
