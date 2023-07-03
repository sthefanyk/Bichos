<?php

namespace Test\Unit\Domain\Entity\Usuario;

use Core\Domain\Entity\Usuario\Abrigo;
use Core\Domain\Entity\Usuario\ValueObjects\Cpf;
use Core\Domain\Entity\Usuario\ValueObjects\Email;
use Core\Domain\Entity\Usuario\ValueObjects\Pessoa;
use Core\Domain\Entity\Usuario\ValueObjects\TipoUsuario;
use Core\Domain\Exception\EntityValidationException;
use DateTime;
use PHPUnit\Framework\TestCase;

class AbrigoUnitTest extends TestCase
{
    public function test_abrigo_atributos()
    {
        $responsavel = new Pessoa(
            cpf: new Cpf('135.028.149-29'),
            nome_completo: 'Sthefany Kimberly',
            data_nascimento: new DateTime('2002/02/27'),
        );
        $abrigo = new Abrigo(
            apelido: 'abrigoApelido',
            email: new Email('abrigo@gmail.com'),
            responsavel: $responsavel,
            nome_abrigo: 'Nome abrigo',
            data_inicio: new DateTime('2015/05/05'),
        );

        $this->assertEquals($responsavel, $abrigo->responsavel);
        $this->assertEquals('Nome abrigo', $abrigo->nome_abrigo);
        $this->assertEquals(new DateTime('2015/05/05'), $abrigo->data_inicio);

        $this->assertEquals('abrigoApelido', $abrigo->apelido);
        $this->assertEquals('abrigoApelido', $abrigo->nome_usuario);
        $this->assertEquals(new Email('abrigo@gmail.com'), $abrigo->email);
        $this->assertEquals(TipoUsuario::ABRIGO, $abrigo->tipo_usuario);
        $this->assertTrue($abrigo->eh_ativo);
        $this->assertNotEmpty($abrigo->id);
    }

    public function test_abrigo_atualizar()
    {
        $responsavel = new Pessoa(
            cpf: new Cpf('135.028.149-29'),
            nome_completo: 'Sthefany Kimberly',
            data_nascimento: new DateTime('2002/02/27'),
        );
        $abrigo = new Abrigo(
            apelido: 'abrigoApelido',
            email: new Email('abrigo@gmail.com'),
            responsavel: $responsavel,
            nome_abrigo: 'Nome abrigo',
            data_inicio: new DateTime('2015/05/05'),
        );

        $responsavel_novo = new Pessoa(
            cpf: new Cpf('135.028.149-29'),
            nome_completo: 'Sthefany',
            data_nascimento: new DateTime('2002/02/27'),
        );
        $abrigo->atualizar(
            novo_nome_abrigo: 'novo nome abrigo',
            nova_data_inicio: new DateTime('2015/06/05'),
            novo_responsavel: $responsavel_novo,
            novo_apelido: 'novoapelido',
            novo_email: new Email('abrigonovo@gmail.com'),
            novo_nome_usuario: 'novonomeusuario'
        );

        $this->assertEquals($responsavel_novo, $abrigo->responsavel);
        $this->assertEquals('novo nome abrigo', $abrigo->nome_abrigo);
        $this->assertEquals(new DateTime('2015/06/05'), $abrigo->data_inicio);

        $this->assertEquals('novoapelido', $abrigo->apelido);
        $this->assertEquals('novonomeusuario', $abrigo->nome_usuario);
        $this->assertEquals(new Email('abrigonovo@gmail.com'), $abrigo->email);
        $this->assertEquals(TipoUsuario::ABRIGO, $abrigo->tipo_usuario);
        $this->assertTrue($abrigo->eh_ativo);
        $this->assertNotEmpty($abrigo->id);
    }

    public function test_abrigo_data_inicio_exception()
    {
        try {
            $responsavel = new Pessoa(
                cpf: new Cpf('135.028.149-29'),
                nome_completo: 'Sthefany Kimberly',
                data_nascimento: new DateTime('2002/02/27'),
            );
            $data = date('Y/m/d', strtotime('+1 days'));
            new Abrigo(
                apelido: 'abrigoApelido',
                email: new Email('abrigo@gmail.com'),
                responsavel: $responsavel,
                nome_abrigo: 'Nome abrigo',
                data_inicio: $data,
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Data inválida!", $th->getMessage());
        }
    }

    public function test_abrigo_nome_abrigo_exception()
    {
        try {
            $responsavel = new Pessoa(
                cpf: new Cpf('135.028.149-29'),
                nome_completo: 'Sthefany Kimberly',
                data_nascimento: new DateTime('2002/02/27'),
            );
            $data = date('Y/m/d', strtotime('+1 days'));
            new Abrigo(
                apelido: 'abrigoApelido',
                email: new Email('abrigo@gmail.com'),
                responsavel: $responsavel,
                nome_abrigo: 'Nome abrigo2',
                data_inicio: $data,
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Nome inválido!", $th->getMessage());
        }
    }
}

