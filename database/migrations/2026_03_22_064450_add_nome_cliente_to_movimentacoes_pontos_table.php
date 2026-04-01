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
            $table->string('nome_cliente', 150)->nullable()->after('data_compra');
        });

        DB::table('movimentacoes_pontos')
            ->whereNull('nome_cliente')
            ->update([
                'nome_cliente' => 'Cliente não informado',
            ]);

        DB::statement("
            ALTER TABLE movimentacoes_pontos
            MODIFY nome_cliente VARCHAR(150) NOT NULL
        ");
    }

    public function down(): void
    {
        Schema::table('movimentacoes_pontos', function (Blueprint $table) {
            $table->dropColumn('nome_cliente');
        });
    }
};