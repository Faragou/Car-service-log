<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    public function up()
    {
        // 2025_03_28_104359_create_services_table.php
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('car_id');
            $table->integer('lognumber'); // lognumber a JSON-ból
            $table->string('event');
            $table->timestamp('eventtime')->nullable(); // eventtime a JSON-ból
            $table->string('document_id');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
        });

    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
}

