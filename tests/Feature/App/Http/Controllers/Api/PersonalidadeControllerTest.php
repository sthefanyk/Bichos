<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Http\Controllers\Api\PersonalidadeController;
use App\Models\Personalidade;
use App\Repositories\Eloquent\PersonalidadeEloquentRepository;
use Core\UseCase\Personalidade\ListPersonalidadesUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Tests\TestCase;

class PersonalidadeControllerTest extends TestCase
{
    protected $repository;
    protected function setUp(): void
    {
        $this->repository = new PersonalidadeEloquentRepository(
            new Personalidade()
        );

        parent::setUp();
    }

    public function test_personalidade_index()
    {
        $usecase = new ListPersonalidadesUseCase($this->repository);

        $controller = new PersonalidadeController();
        $response = $controller->index(new Request(), $usecase);

        $this->assertInstanceOf(AnonymousResourceCollection::class, $response);
        $this->assertArrayHasKey('meta', $response->additional);

    }
}
