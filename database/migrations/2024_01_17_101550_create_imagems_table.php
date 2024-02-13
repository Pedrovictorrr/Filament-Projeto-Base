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
        Schema::create('imagems', function (Blueprint $table) {
            $table->id();
            $table->text('imagem1')->nullable();
            $table->text('imagem1-nome')->nullable();
            $table->string('imagem2')->nullable();
            $table->string('imagem2-nome')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagems');
    }
};
