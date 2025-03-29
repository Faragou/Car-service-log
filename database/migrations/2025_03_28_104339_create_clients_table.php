<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        // 2025_03_28_104339_create_clients_table.php
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('card_name')->nullable(); // Korábbi 'idcard' oszlop helyett
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}

