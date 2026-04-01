<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Premio extends Model
{
    use HasFactory;

    protected $table = 'premios';

    protected $fillable = [
        'nome',
        'descricao',
        'pontos_resgate',
        'ativo',
        'imagem',
    ];

    public function resgates()
    {
        return $this->hasMany(Resgate::class, 'fk_premio');
    }
}