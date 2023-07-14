<?php

namespace Test\Unit\Domain\Entity\Personalidade;

use PHPUnit\Framework\TestCase;
use Core\Domain\Entity\Personalidade;
use Core\Domain\Entity\Uuid;
use Core\Domain\Exception\EntityValidationException;
use Ramsey\Uuid\Uuid as RamseyUuid;
use DateTime;

class PersonalidadeUnitTest extends TestCase
{
    public function test_personalidade_atributos(){
        $uuid = (string) RamseyUuid::uuid4();
        $data = date('Y-m-d H:i:s');

        $personalidade = new Personalidade(
            id: new Uuid($uuid),
            nome: 'New personalidade',
            eh_ativo: false,
            data_criacao: new DateTime($data)
        );

        $this->assertEquals($uuid, $personalidade->id());
        $this->assertEquals('New personalidade', $personalidade->nome);
        $this->assertFalse($personalidade->eh_ativo);
        $this->assertEquals($data, $personalidade->data_criacao());
    }

    public function test_personalidade_atributos_criados(){

        $personalidade = new Personalidade(
            nome: 'New personalidade',
        );

        $this->assertNotEmpty($personalidade->id());
        $this->assertEquals('New personalidade', $personalidade->nome);
        $this->assertTrue($personalidade->eh_ativo);
        $this->assertNotEmpty($personalidade->data_criacao());
    }

    public function test_personalidade_ativar(){
        $uuid = (string) RamseyUuid::uuid4();
        $data = date('Y-m-d H:i:s');

        $personalidade = new Personalidade(
            id: new Uuid($uuid),
            nome: 'New personalidade',
            eh_ativo: false,
            data_criacao: new DateTime($data)
        );

        $this->assertFalse($personalidade->eh_ativo);

        $personalidade->ativar();

        $this->assertTrue($personalidade->eh_ativo);
    }

    public function test_personalidade_desativar(){
        $uuid = (string) RamseyUuid::uuid4();
        $data = date('Y-m-d H:i:s');

        $personalidade = new Personalidade(
            id: new Uuid($uuid),
            nome: 'New personalidade',
            eh_ativo: true,
            data_criacao: new DateTime($data)
        );

        $this->assertTrue($personalidade->eh_ativo);

        $personalidade->desativar();
        
        $this->assertFalse($personalidade->eh_ativo);
    }

    public function test_personalidade_atualizar(){

        $personalidade = new Personalidade(
            nome: 'New personalidade'
        );
        
        $this->assertEquals('New personalidade', $personalidade->nome);

        $personalidade->atualizar(
            nome: 'Nova personalidade',
        );

        $this->assertEquals('Nova personalidade', $personalidade->nome);
    }

    public function test_personalidade_exception(){

        $this->expectException(EntityValidationException::class);

        new Personalidade(
            nome: 'N'
        );
    }

    public function test_personalidade_atualizar_exception(){

        $this->expectException(EntityValidationException::class);

        $uuid = (string) RamseyUuid::uuid4();
        $data = date('Y-m-d H:i:s');

        $personalidade = new Personalidade(
            id: new Uuid($uuid),
            nome: 'New personalidade',
            eh_ativo: true,
            data_criacao: new DateTime($data)
        );

        $personalidade->atualizar(
            nome: 'N'
        );
    }
}

