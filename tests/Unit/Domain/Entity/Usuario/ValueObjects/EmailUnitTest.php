<?php

namespace Tests\Unit\Domain\Entity\Usuario\ValueObjects;

use Core\Domain\Entity\Usuario\ValueObjects\Email;
use Core\Domain\Exception\EntityValidationException;
use DateTime;

use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class EmailUnitTest extends TestCase
{
    public function test_email_atributos()
    {
        $email = new Email(
            email: 'email@dominio.com'
        );

        assertEquals('email@dominio.com', $email->email);
    }

    public function test_email_invalido_mensagem()
    {
        try {
            $email = new Email(
                email: 'emaildominio.com'
            );
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, "Email invalido!");
            $this->assertEquals("Email inválido!", $th->getMessage());
        }
    }

    public function test_email_nao_validado()
    {
        $email = new Email(
            email: 'email@dominio.com'
        );

        $this->assertEmpty($email->data_validacao);
    }

    public function test_email_validado()
    {
        $email = new Email(
            email: 'email@dominio.com'
        );

        $email->validarEmail();

        $this->assertNotEmpty($email->data_validacao);
    }

    public function test_email_validado_passando_data()
    {
        $data = '2023/07/02 12:10:10';

        $email = new Email(
            email: 'email@dominio.com'
        );

        $response = $email->validarEmail($data);
        $expected = new DateTime('2023/07/02 12:10:10');

        $this->assertNotEmpty($email->data_validacao);

        $this->assertEquals($expected, $response);
    }


}
