<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeederTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\Gleandroj\Api\Database\Seeds\Seeder::$table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('seeder');
            $table->string('environment');
            $table->timestamp('ran_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(\Gleandroj\Api\Database\Seeds\Seeder::$table);
    }
}
