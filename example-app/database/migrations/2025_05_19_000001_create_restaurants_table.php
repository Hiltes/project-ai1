<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {

            $table->id();

            $table->foreignId('owner_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('name');
            $table->text('address');
            $table->string('phone');
            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index('owner_id');
            $table->index('is_active');

            $table->unique(['owner_id', 'name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
};
