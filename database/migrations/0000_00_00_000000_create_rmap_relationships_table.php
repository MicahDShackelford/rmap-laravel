<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rmap_relationships', function (Blueprint $table) {
            $table->id();

            $table->string('origin_table');
            $table->string('origin_column');

            $table->string('target_connection');
            $table->string('target_schema')->nullable();
            $table->string('target_table');
            $table->string('target_column');

            $table->timestamps();
        });
    }
};
