<?php

namespace Test\Unit\Domain\Entity\Usuario;

use Core\Domain\Entity\Usuario\Associacao;
use Core\Domain\Entity\Usuario\ValueObjects\Cnpj;
use Core\Domain\Entity\Usuario\ValueObjects\Email;
use Core\Domain\Entity\Usuario\ValueObjects\TipoUsuario;
use Core\Domain\Exception\EntityValidationException;
use DateTime;
use PHPUnit\Framework\TestCase;

class AssociacaoUnitTest extends TestCase
{
    public function test_associacao_atributos()
    {
        $associacao = new Associacao(
            cnpj: new Cnpj('56.534.867/0001-81'),
            nome_associacao: 'nome ong',
            data_registro: new DateTime('2018/02/02'),
            apelido: 'ongApelido',
            nome_usuario: 'nome usuario ong',
            email: new Email('ong@gmail.com'),
        );

        $this->assertEquals(new Cnpj('56.534.867/0001-81'), $associacao->cnpj);
        $this->assertEquals('nome ong', $associacao->nome_associacao);
        $this->assertEquals(new DateTime('2018/02/02'), $associacao->data_registro);

        $this->assertEquals('ongApelido', $associacao->apelido);
        $this->assertEquals('nome usuario ong', $associacao->nome_usuario);
        $this->assertEquals(new Email('ong@gmail.com'), $associacao->email);
        $this->assertEquals(TipoUsuario::ASSOCIACAO, $associacao->tipo_usuario);
        $this->assertTrue($associacao->eh_ativo);
        $this->assertNotEmpty($associacao->id);
    }

    public function test_associacao_atualizar()
    {
        $associacao = new Associacao(
            cnpj: new Cnpj('56.534.867/0001-81'),
            nome_associacao: 'nome ong',
            data_registro: new DateTime('2018/02/02'),
            apelido: 'ongApelido',
            nome_usuario: 'nome usuario ong',
            email: new Email('ong@gmail.com'),
        );

        $associacao->atualizar(
            novo_cnpj: new Cnpj('33.247.151/0001-06'),
            novo_nome_associacao: 'novo nome ong',
            nova_data_registro: new DateTime('2018/02/03'),
            novo_apelido: 'ongApelidoNovo',
            novo_nome_usuario: 'novo nome usuario ong',
            novo_email: new Email('ongnova@gmail.com'),
        );

        $this->assertEquals(new Cnpj('33.247.151/0001-06'), $associacao->cnpj);
        $this->assertEquals('novo nome ong', $associacao->nome_associacao);
        $this->assertEquals(new DateTime('2018/02/03'), $associacao->data_registro);

        $this->assertEquals('ongApelidoNovo', $associacao->apelido);
        $this->assertEquals('novo nome usuario ong', $associacao->nome_usuario);
        $this->assertEquals(new Email('ongnova@gmail.com'), $associacao->email);
        $this->assertEquals(TipoUsuario::ASSOCIACAO, $associacao->tipo_usuario);
        $this->assertTrue($associacao->eh_ativo);
        $this->assertNotEmpty($associacao->id);
    }

    public function test_associacao_data_registro_exception()
    {
        try {
            $data = date('Y/m/d', strtotime('+1 days'));
            new Associacao(
                cnpj: new Cnpj('56.534.867/0001-81'),
                nome_associacao: 'nome ong',
                data_registro: $data,
                apelido: 'ongApelido',
                nome_usuario: 'nome usuario ong',
                email: new Email('ong@gmail.com'),
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Data inválida!", $th->getMessage());
        }
    }

    public function test_associacao_nome_associacao_exception()
    {
        try {
            new Associacao(
                cnpj: new Cnpj('56.534.867/0001-81'),
                nome_associacao: 'nome ong2',
                data_registro: new DateTime('2018/02/03'),
                apelido: 'ongApelido',
                nome_usuario: 'nome usuario ong',
                email: new Email('ong@gmail.com'),
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Nome inválido!", $th->getMessage());
        }
    }
}
