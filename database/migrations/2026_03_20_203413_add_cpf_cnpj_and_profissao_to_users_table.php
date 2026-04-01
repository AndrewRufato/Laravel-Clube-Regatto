<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'cpf_cnpj')) {
                $table->string('cpf_cnpj', 14)->nullable()->unique()->after('telefone');
            }

            if (!Schema::hasColumn('users', 'profissao')) {
                $table->string('profissao', 30)->nullable()->after('cpf_cnpj');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'profissao')) {
                $table->dropColumn('profissao');
            }

            if (Schema::hasColumn('users', 'cpf_cnpj')) {
                try {
                    $table->dropUnique('users_cpf_cnpj_unique');
                } catch (\Throwable $e) {
                }

                $table->dropColumn('cpf_cnpj');
            }
        });
    }
};