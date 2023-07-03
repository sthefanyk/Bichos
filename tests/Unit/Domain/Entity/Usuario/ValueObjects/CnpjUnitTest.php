<?php

namespace Tests\Unit\Domain\Entity\Usuario\ValueObjects;

use Core\Domain\Entity\Usuario\ValueObjects\Cnpj;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;

class CnpjUnitTest extends TestCase
{
    public function test_cnpj_erro_tamanho()
    {
        try {
            new Cnpj('123.123.123-1');
            $this->assertTrue(false);

        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("CNPJ deve conter 14 digitos!", $th->getMessage());
        }
    }

    public function test_cnpj_invalido()
    {
        try {
            new Cnpj('11.111.111/1111-12');
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("CNPJ inválido!", $th->getMessage());
        }
    }

    public function test_cpf_valido()
    {
        $cnpj = new Cnpj('56.534.867/0001-81');
        $this->assertEquals('56.534.867/0001-81', $cnpj->cnpj);
    }
}

