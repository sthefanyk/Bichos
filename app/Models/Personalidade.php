<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Personalidade extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'nome',
        'eh_ativo'
    ];

    public $incrementing = false;

    protected $casts = [
        'id' => 'string',
        'eh_ativo' => 'boolean',
    ];
}
