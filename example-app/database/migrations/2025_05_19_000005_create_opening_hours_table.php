<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('opening_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->enum('day_of_week', [
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday'
            ]);
            $table->time('open_time');
            $table->time('close_time');
            $table->timestamps();

            // Dodatkowy indeks dla lepszej wydajności
            $table->index(['restaurant_id', 'day_of_week']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('opening_hours');
    }
};
