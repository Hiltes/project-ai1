<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->text('address')->nullable();


            $table->enum('role', [
                'customer',
                'restaurant_owner',
                'courier',
                'admin'
            ])->default('customer');


            $table->timestamps();

            $table->rememberToken();


            $table->index('email');
            $table->index('role');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
