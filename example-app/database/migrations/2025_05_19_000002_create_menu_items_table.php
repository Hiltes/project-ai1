<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);

            $table->string('category');

            $table->foreignId('restaurant_id')
                  ->constrained()
                  ->onDelete('cascade'); // Kasuje pozycje menu przy usunięciu restauracji

            $table->timestamps();

            $table->index('restaurant_id');
            $table->index('name');
            $table->index('category'); // dodany indeks dla szybszych zapytań po kategorii
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
};
