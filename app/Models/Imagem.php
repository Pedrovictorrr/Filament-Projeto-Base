<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
    use HasFactory;

    protected $table = 'imagems';
    protected $fillable = [
        'imagem1',
        'imagem1-nome',
        'imagem2',
        'imagem2-nome',
    ];
    protected $casts = [
        'imagem1'=> 'array',
        'imagem1-nome'=> 'array',
        'imagem2'=> 'array',
        'imagem2-nome'=> 'array',
    ];
}
