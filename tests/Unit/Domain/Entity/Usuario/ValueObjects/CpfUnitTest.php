<?php

namespace Tests\Unit\Domain\Entity\Usuario\ValueObjects;

use Core\Domain\Entity\Usuario\ValueObjects\Cpf;
use Core\Domain\Exception\EntityValidationException;

use PHPUnit\Framework\TestCase;

class CpfUnitTest extends TestCase
{
    public function test_cpf_erro_tamanho()
    {
        try {
            new Cpf('123.123.123-1');
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("CPF deve conter 11 digitos!", $th->getMessage());
        }
    }

    public function test_cpf_erro_digitos_repetidos()
    {
        try {
            new Cpf('111.111.111-11');
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Digito repetidos!", $th->getMessage());
        }
    }

    public function test_cpf_erro_cpf_invalido()
    {
        try {
            new Cpf('111.111.111-12');
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("CPF inválido!", $th->getMessage());
        }
    }

    public function test_cpf_valido()
    {
        $cpf = new Cpf('135.028.149-29');
        $this->assertEquals('135.028.149-29', $cpf->cpf);
    }

}

