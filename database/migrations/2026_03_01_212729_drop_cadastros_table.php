<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('cadastros');
    }

    public function down(): void
    {
        // Caso queira restaurar no futuro,
        // teria que recriar a estrutura aqui
    }
};