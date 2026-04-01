<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resgate extends Model
{
    use HasFactory;

    protected $table = 'resgates';

    protected $fillable = [
        'fk_user',
        'fk_premio',
        'pontos_gasto',
        'saldo_user_antes_do_resgate',
        'saldo_user_pos_resgate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_user');
    }

    public function premio()
    {
        return $this->belongsTo(Premio::class, 'fk_premio');
    }
}