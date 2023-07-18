<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Personalidade as Model;
use App\Repositories\Eloquent\PersonalidadeEloquentRepository;
use Core\Domain\Entity\Personalidade as Entity;
use Core\Domain\Entity\Uuid;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\PaginationInterface;
use Core\Domain\Repository\PersonalidadeRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Throwable;

class PersonalidadeEloquentRepositoryTest extends TestCase
{

    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new PersonalidadeEloquentRepository(new Model());
    }

    public function test_personalidade_insert()
    {
        $entity = new Entity(nome: 'Teste');

        $response = $this->repository->insert($entity);

        $this->assertInstanceOf(PersonalidadeRepositoryInterface::class, $this->repository);
        $this->assertInstanceOf(Entity::class, $response);

        $this->assertEquals($entity->nome, $response->nome);
        $this->assertEquals($entity->id, $response->id);
        $this->assertEquals($entity->eh_ativo, $response->eh_ativo);
        $this->assertEquals($entity->data_criacao(), $response->data_criacao());

        $this->assertDatabaseHas('personalidades',[
            'id' => $entity->id(),
            'nome' => $entity->nome,
            'eh_ativo' => $entity->eh_ativo,
            'created_at' => $entity->data_criacao()
        ]);
    }

    public function test_personalidade_find_by_id()
    {
        $personalidade = Model::factory()->create();

        $response = $this->repository->findById($personalidade->id);

        $this->assertInstanceOf(Entity::class, $response);
        $this->assertEquals($personalidade->id, $response->id());
        $this->assertEquals($personalidade->nome, $response->nome);
        $this->assertEquals($personalidade->eh_ativo, $response->eh_ativo);
        $this->assertEquals($personalidade->created_at, $response->data_criacao());
    }

    public function test_personalidade_find_by_id_not_found()
    {
        try {
            $this->repository->findById('fakeValue');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function test_personalidade_find_all()
    {
        $personalidades = Model::factory()->count(10)->create();

        $response  = $this->repository->findAll();

        $this->assertEquals(count($personalidades), count($response));
    }

    public function test_personalidade_paginate()
    {
        Model::factory()->count(20)->create();

        $response  = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(15, $response->items());
    }

    public function test_personalidade_paginate_without()
    {
        $response  = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(0, $response->items());
    }

    public function test_personalidade_update()
    {
        $personalidadeDb  = Model::factory()->create();

        $personalidade = new Entity(
            id: new Uuid($personalidadeDb->id),
            nome: 'updated name'
        );

        $response = $this->repository->update($personalidade);

        $this->assertInstanceOf(Entity::class, $response);
        $this->assertNotEquals($response->nome, $personalidadeDb->nome);
        $this->assertEquals('updated name', $response->nome);
    }

    public function test_personalidade_update_id_not_found()
    {
        try {
            $personalidade = new Entity(nome: 'test');
            $this->repository->update($personalidade);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function test_personalidade_delete()
    {
        $personalidade = Model::factory()->create();

        $response = $this->repository->delete($personalidade->id);

        $this->assertSoftDeleted('personalidades', [
            'id' => $personalidade->id,
        ]);

        $this->assertTrue($response);
    }

    public function test_personalidade_delete_not_found()
    {
        $this->expectException(NotFoundException::class);

        $this->repository->delete('fake_id');
    }
}
