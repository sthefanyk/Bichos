<?php

namespace Tests\Unit\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Personalidade;
use Illuminate\Database\Eloquent\Model;
use Tests\Unit\App\Models\ModelTestCase;


class PersonalidadeUnitTest extends ModelTestCase
{
    protected function model() : Model
    {
        return new Personalidade();
    }

    protected function traits() : array
    {
        return [
            HasFactory::class,
            SoftDeletes::class,
        ];
    }

    protected function fillables() : array
    {
        return [
            'id',
            'nome',
            'eh_ativo'
        ];
    }

    protected function casts() : array
    {
        return [
            'id' => 'string',
            'eh_ativo' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }

    
}
