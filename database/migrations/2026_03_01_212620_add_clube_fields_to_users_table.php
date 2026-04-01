<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('telefone')->nullable()->after('email');

            $table->decimal('pontos', 10, 2)
                  ->default(0)
                  ->after('telefone');

            $table->string('rrt')->nullable()
                  ->after('pontos');

            $table->enum('aprovado', ['S', 'N'])
                  ->default('N')
                  ->after('rrt');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'telefone',
                'pontos',
                'rrt',
                'aprovado'
            ]);
        });
    }
};