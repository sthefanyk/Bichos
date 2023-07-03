<?php

use Core\Domain\Entity\Usuario\ValueObjects\Cpf;
use Core\Domain\Entity\Usuario\ValueObjects\Pessoa;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class PessoaUnitTest extends TestCase
{
    public function test_nome_completo_vazio_exception()
    {
        try {
            $cpf = new Cpf('135.028.149-29');

            new Pessoa(
                nome_completo: '',
                cpf: $cpf,
                data_nascimento: '2002/02/27',
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Não pode ser vazio ou nulo!", $th->getMessage());
        }
    }

    public function test_nome_completo_min_exception()
    {
        try {
            $cpf = new Cpf('135.028.149-29');

            new Pessoa(
                nome_completo: 'a',
                cpf: $cpf,
                data_nascimento: '2002/02/27',
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Não pode ter menos que 3 caracteres!", $th->getMessage());
        }
    }

    public function test_nome_completo_invalido_exception()
    {
        try {
            $cpf = new Cpf('135.028.149-29');

            new Pessoa(
                nome_completo: 'nome_completo',
                cpf: $cpf,
                data_nascimento: '2002/02/27',
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Nome inválido!", $th->getMessage());
        }
    }

    public function test_nome_completo_valido()
    {
        $cpf = new Cpf('135.028.149-29');
        $nome = 'Sthefany Kimberly Vitória da Silva Mendes';

        $response = new Pessoa(
            nome_completo: $nome,
            cpf: $cpf,
            data_nascimento: '2002/02/27',
        );

        $this->assertEquals($nome, $response->nome_completo);
    }

    public function test_conversao_atributo_data_nascimento()
    {
        $cpf = new Cpf('135.028.149-29');

        $pessoa = new Pessoa(
            nome_completo: 'nome completo',
            cpf: $cpf,
            data_nascimento: '2002/02/27',
        );

        $data = new DateTime('2002/02/27');
        $this->assertEquals($data, $pessoa->data_nascimento);
    }

    public function test_data_nascimento_invalida()
    {
        try {
            $cpf = new Cpf('135.028.149-29');
            $data = date('Y/m/d', strtotime('+1 days'));

            new Pessoa(
                nome_completo: 'nome completo',
                cpf: $cpf,
                data_nascimento: $data,
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Data inválida!", $th->getMessage());
        }
    }

    public function test_data_nascimento_menor_idade()
    {
        try {
            $cpf = new Cpf('135.028.149-29');
            $data = date('Y/m/d', strtotime('-17 year'));

            new Pessoa(
                nome_completo: 'nome completo',
                cpf: $cpf,
                data_nascimento: $data,
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Idade menor que 18!", $th->getMessage());
        }
    }
}
