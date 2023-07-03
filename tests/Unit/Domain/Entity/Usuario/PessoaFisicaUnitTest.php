<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Usuario\PessoaFisica;
use Core\Domain\Entity\Usuario\ValueObjects\Cpf;
use Core\Domain\Entity\Usuario\ValueObjects\Email;
use Core\Domain\Entity\Usuario\ValueObjects\Pessoa;
use Core\Domain\Entity\Usuario\ValueObjects\TipoUsuario;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PessoaFisicaUnitTest extends TestCase
{
    public function test_pessoa_fisica_atributos()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $email = new Email("email@example.com");
        $cpf = new Cpf('135.028.149-29');
        $pessoa = new Pessoa(
            cpf: $cpf,
            nome_completo: 'nome completo',
            data_nascimento: '2002/02/27'
        );

        $pessoa_fisica = new PessoaFisica(
            id: $uuid,
            apelido: 'apelido',
            email: $email,
            pessoa: $pessoa,
            data_criacao: '2023/07/03',
        );

        $this->assertEquals($uuid, $pessoa_fisica->id);
        $this->assertEquals('apelido', $pessoa_fisica->apelido);
        $this->assertEquals('apelido', $pessoa_fisica->nome_usuario);
        $this->assertEquals($email, $pessoa_fisica->email);
        $this->assertEquals(TipoUsuario::PESSOA_FISICA, $pessoa_fisica->tipo_usuario);
        $this->assertEquals(true, $pessoa_fisica->eh_ativo);
        $this->assertEquals($pessoa, $pessoa_fisica->pessoa);
        $this->assertEquals('2023/07/03', $pessoa_fisica->data_criacao('Y/m/d'));
    }

    public function test_pessoa_fisica_atualizar()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $email = new Email("email@example.com");
        $cpf = new Cpf('135.028.149-29');
        $pessoa = new Pessoa(
            cpf: $cpf,
            nome_completo: 'nome completo',
            data_nascimento: '2002/02/27'
        );

        $pessoa_fisica = new PessoaFisica(
            id: $uuid,
            apelido: 'apelido',
            email: $email,
            pessoa: $pessoa,
        );

        $novo_email = new Email("emailnovo@example.com");
        $cpf = new Cpf('135.028.149-29');
        $nova_pessoa = new Pessoa(
            cpf: $cpf,
            nome_completo: 'nome completo aaaaaa',
            data_nascimento: '2002/02/26'
        );

        $pessoa_fisica->atualizar(
            novo_apelido: 'novoapelido',
            novo_email: $novo_email,
            nova_pessoa: $nova_pessoa,
            novo_nome_usuario: 'novonomeusuario',
            data_criacao: '2023/07/02',
        );

        $this->assertEquals('novoapelido', $pessoa_fisica->apelido);
        $this->assertEquals('novonomeusuario', $pessoa_fisica->nome_usuario);
        $this->assertEquals($nova_pessoa, $pessoa_fisica->pessoa);
        $this->assertEquals($novo_email, $pessoa_fisica->email);
        $this->assertEquals('2023/07/02', $pessoa_fisica->data_criacao('Y/m/d'));
    }

    public function test_pessoa_fisica_atualizar_parametro_opcional()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $email = new Email("email@example.com");
        $cpf = new Cpf('135.028.149-29');
        $pessoa = new Pessoa(
            cpf: $cpf,
            nome_completo: 'nome completo',
            data_nascimento: '2002/02/27'
        );

        $pessoa_fisica = new PessoaFisica(
            id: $uuid,
            apelido: 'apelido',
            email: $email,
            pessoa: $pessoa,
        );

        $pessoa_fisica->atualizar(
            novo_apelido: 'novoapelido'
        );

        $this->assertEquals('novoapelido', $pessoa_fisica->apelido);
        $this->assertEquals('apelido', $pessoa_fisica->nome_usuario);
        $this->assertEquals($pessoa, $pessoa_fisica->pessoa);
        $this->assertEquals($email, $pessoa_fisica->email);
    }

    public function test_usuario_uuid_vazio()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $email = new Email("email@example.com");
        $cpf = new Cpf('135.028.149-29');
        $pessoa = new Pessoa(
            cpf: $cpf,
            nome_completo: 'nome completo',
            data_nascimento: '2002/02/27'
        );

        $pessoa_fisica = new PessoaFisica(
            apelido: 'apelido',
            email: $email,
            pessoa: $pessoa,
        );

        $this->assertNotEmpty($pessoa_fisica->id);
    }

    public function test_usuario_ativar_desativar()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $email = new Email("email@example.com");
        $cpf = new Cpf('135.028.149-29');
        $pessoa = new Pessoa(
            cpf: $cpf,
            nome_completo: 'nome completo',
            data_nascimento: '2002/02/27'
        );

        $pessoa_fisica = new PessoaFisica(
            apelido: 'apelido',
            email: $email,
            pessoa: $pessoa,
        );

        $this->assertTrue($pessoa_fisica->eh_ativo);
        $pessoa_fisica->desativar_usuario();
        $this->assertFalse($pessoa_fisica->eh_ativo);
        $pessoa_fisica->ativar_usuario();
        $this->assertTrue($pessoa_fisica->eh_ativo);
    }

    public function test_usuario_apelido_exception()
    {
        try {
            $uuid = (string) Uuid::uuid4()->toString();
            $email = new Email("email@example.com");
            $cpf = new Cpf('135.028.149-29');
            $pessoa = new Pessoa(
                cpf: $cpf,
                nome_completo: 'nome completo',
                data_nascimento: '2002/02/27'
            );

            $pessoa_fisica = new PessoaFisica(
                id: $uuid,
                apelido: 'apelido',
                email: $email,
                pessoa: $pessoa,
            );

            $pessoa_fisica->atualizar(
                novo_apelido: 'novo apelido'
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Apelido inválido!", $th->getMessage());
        }
    }

    public function test_usuario_nome_usuario_min_exception()
    {

        try {
            $uuid = (string) Uuid::uuid4()->toString();
            $email = new Email("email@example.com");
            $cpf = new Cpf('135.028.149-29');
            $pessoa = new Pessoa(
                cpf: $cpf,
                nome_completo: 'nome completo',
                data_nascimento: '2002/02/27'
            );

            $pessoa_fisica = new PessoaFisica(
                id: $uuid,
                apelido: 'apelido',
                email: $email,
                pessoa: $pessoa,
            );

            $pessoa_fisica->atualizar(
                novo_nome_usuario: 'n'
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Não pode ter menos que 3 caracteres!", $th->getMessage());
        }
    }

    public function test_usuario_apelido_not_null_exception()
    {

        try {
            $uuid = (string) Uuid::uuid4()->toString();
            $email = new Email("email@example.com");
            $cpf = new Cpf('135.028.149-29');
            $pessoa = new Pessoa(
                cpf: $cpf,
                nome_completo: 'nome completo',
                data_nascimento: '2002/02/27'
            );

            $pessoa_fisica = new PessoaFisica(
                id: $uuid,
                apelido: '',
                email: $email,
                pessoa: $pessoa,
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Não pode ser vazio ou nulo!", $th->getMessage());
        }
    }
}
