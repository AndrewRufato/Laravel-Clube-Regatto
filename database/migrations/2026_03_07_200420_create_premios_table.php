<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('premios', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->double('pontos_resgate', 10, 2);
            $table->string('descricao', 1000)->nullable();
            $table->char('ativo', 1)->default('S'); // S ou N
            $table->string('imagem')->nullable();   // caminho da imagem
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('premios');
    }
};