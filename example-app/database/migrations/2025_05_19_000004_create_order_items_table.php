<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('menu_item_id')->constrained()->onDelete('restrict');
            $table->integer('quantity')->unsigned()->default(1);
            $table->timestamps();

            $table->unique(['order_id', 'menu_item_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
