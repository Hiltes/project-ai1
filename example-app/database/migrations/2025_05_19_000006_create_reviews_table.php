<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // AUTO_INCREMENT + PRIMARY KEY
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned(); // Liczba 1-5
            $table->text('comment')->nullable(); // Komentarz może być pusty
            $table->timestamps(); // created_at + updated_at

            // Indeksy dla szybkiego wyszukiwania
            $table->index(['restaurant_id', 'rating']);
        });

    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
