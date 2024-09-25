<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('non_bonded_wood', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_type');
            $table->unsignedBigInteger('id_wood');
            $table->string('image')->nullable();
            $table->string('size');
            $table->integer('price');
            $table->timestamps();

            $table->foreign('id_type')->references('id')->on('type_wood');
            $table->foreign('id_wood')->references('id')->on('wood');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('non_bonded_wood');
    }
};
