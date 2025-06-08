<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::table('restaurants', function (Blueprint $table) {
        $table->float('rating')->default(0);
        $table->unsignedInteger('rating_count')->default(0);
    });
}

public function down()
{
    Schema::table('restaurants', function (Blueprint $table) {
        $table->dropColumn(['rating', 'rating_count']);
    });
}

};
