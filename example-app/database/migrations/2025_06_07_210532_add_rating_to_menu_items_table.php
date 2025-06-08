<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->decimal('rating', 2, 1)->default(0); 
            $table->unsignedInteger('rating_count')->default(0);
        });
    }

    public function down()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn(['rating', 'rating_count']);
        });
    }
};
