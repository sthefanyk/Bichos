<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Personalidade as Model;
use Core\Domain\Entity\Personalidade as Entity;
use App\Repositories\Eloquent\PersonalidadeEloquentRepository;
use Core\Domain\Repository\PersonalidadeRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonalidadeEloquentRepositoryTest extends TestCase
{
    public function test_insert()
    {
        $repository = new PersonalidadeEloquentRepository(new Model());

        $entity = new Entity(nome: 'Teste');

        $response = $repository->insert($entity);

        $this->assertInstanceOf(PersonalidadeRepositoryInterface::class, $repository);
        $this->assertInstanceOf(Entity::class, $response);
        $this->assertDatabaseHas('personalidades',[
            'nome' => $entity->nome
        ]);
    }
}
