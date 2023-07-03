<?php

namespace Tests\Unit\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;

use PHPUnit\Framework\TestCase;

class DomainValidationUnitTest extends TestCase
{
    public function test_not_null_exception()
    {
        try {
            $value = '';
            DomainValidation::notNull($value);

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Não pode ser vazio ou nulo!", $th->getMessage());
        }
    }

    public function test_not_null_exception_customizada()
    {
        try {
            $value = '';
            DomainValidation::notNull($value, 'teste');

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals('teste', $th->getMessage());
        }

    }

    public function test_str_max_length_exception()
    {
        try {
            $value = 'Testee';
            DomainValidation::strMaxlength($value, 5);

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Não pode ter mais que 5 caracteres!", $th->getMessage());
        }
    }

    public function test_str_min_length_exception()
    {
        try {
            $value = 'Testee';
            DomainValidation::strMinlength($value, 7);

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Não pode ter menos que 7 caracteres!", $th->getMessage());
        }
    }
}
