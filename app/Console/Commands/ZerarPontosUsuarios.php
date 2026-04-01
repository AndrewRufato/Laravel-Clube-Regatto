<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ZerarPontosUsuarios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pontos:zerar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Zera os pontos de todos os usuários no início do ano';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $total = User::query()->update([
            'pontos' => 0,
        ]);

        $this->info("Pontos zerados com sucesso. Usuários afetados: {$total}");

        return Command::SUCCESS;
    }
}