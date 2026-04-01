<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movimentacoes_pontos', function (Blueprint $table) {
            $table->string('projeto', 50)->nullable()->after('tipo_mov');
            $table->date('data_compra')->nullable()->after('projeto');
        });

        DB::table('movimentacoes_pontos')
            ->whereNull('projeto')
            ->update([
                'projeto' => 'Cadastro anterior',
            ]);

        DB::table('movimentacoes_pontos')
            ->whereNull('data_compra')
            ->update([
                'data_compra' => now()->toDateString(),
            ]);

        DB::statement("
            ALTER TABLE movimentacoes_pontos
            MODIFY projeto VARCHAR(50) NOT NULL
        ");

        DB::statement("
            ALTER TABLE movimentacoes_pontos
            MODIFY data_compra DATE NOT NULL
        ");
    }

    public function down(): void
    {
        Schema::table('movimentacoes_pontos', function (Blueprint $table) {
            $table->dropColumn(['projeto', 'data_compra']);
        });
    }
};