<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimentacaoPonto extends Model
{
    protected $table = 'movimentacoes_pontos';

    protected $fillable = [
        'fk_user_admin',
        'fk_user_club',
        'pontos_pre_mov',
        'pontos_pos_mov',
        'pontos_mov',
        'tipo_mov',
        'projeto',
        'data_compra',
        'nome_cliente',
    ];

    protected $casts = [
        'pontos_pre_mov' => 'decimal:2',
        'pontos_pos_mov' => 'decimal:2',
        'pontos_mov'     => 'decimal:2',
        'data_compra'    => 'date:Y-m-d',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'fk_user_admin');
    }

    public function clubUser()
    {
        return $this->belongsTo(User::class, 'fk_user_club');
    }
}