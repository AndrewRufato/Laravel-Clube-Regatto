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
        Schema::create('movimentacoes_pontos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fk_user_admin')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('fk_user_club')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->decimal('pontos_pre_mov', 12, 2)->default(0);
            $table->decimal('pontos_pos_mov', 12, 2)->default(0);
            $table->decimal('pontos_mov', 12, 2)->default(0);

            $table->enum('tipo_mov', ['ADD', 'SUB']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentacoes_pontos');
    }
};