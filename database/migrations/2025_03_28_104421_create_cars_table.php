<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    public function up()
    {
        // 2025_03_28_104421_create_cars_table.php
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('car_id');
            $table->string('type');
            $table->timestamp('registered')->nullable();
            $table->boolean('ownbrand'); // 1/0 értékek
            $table->integer('accident')->default(0); // 'accident' a JSON-ban
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });

    }

    public function down()
    {
        Schema::dropIfExists('cars');
    }
}

