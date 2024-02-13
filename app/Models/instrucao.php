<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class instrucao extends Model
{
    use HasFactory;

    protected $fillable = ['texto', 'alias','SKU'];

    protected $table = 'instrucao';
}
