<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Usuario;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class UsuarioUnitTest extends TestCase
{
    public function test_atributos()
    {
        $usuario = new Usuario(
            id: 'Novo id',
            nome: 'Novo nome',
            apelido: 'Novo apelido',
            email: 'Novo email',
            tipo: 'Novo tipo',
            eh_ativo: true,
        );

        assertEquals("Novo nome", $usuario->nome);
    }
}
