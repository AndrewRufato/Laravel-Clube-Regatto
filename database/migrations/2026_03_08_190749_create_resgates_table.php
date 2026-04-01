<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resgates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fk_user')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('fk_premio')
                ->constrained('premios')
                ->cascadeOnDelete();

            $table->integer('pontos_gasto');
            $table->integer('saldo_user_antes_do_resgate');
            $table->integer('saldo_user_pos_resgate');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resgates');
    }
};