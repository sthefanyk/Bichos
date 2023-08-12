<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Http\Controllers\Api\PersonalidadeController;
use App\Http\Requests\StorePersonalidadeRequest;
use App\Http\Requests\UpdatePersonalidadeRequest;
use App\Models\Personalidade;
use App\Repositories\Eloquent\PersonalidadeEloquentRepository;
use Core\UseCase\Personalidade\CreatePersonalidadeUseCase;
use Core\UseCase\Personalidade\DeletePersonalidadeUseCase;
use Core\UseCase\Personalidade\ListPersonalidadesUseCase;
use Core\UseCase\Personalidade\ListPersonalidadeUseCase;
use Core\UseCase\Personalidade\UpdatePersonalidadeUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\TestCase;

class PersonalidadeControllerTest extends TestCase
{
    protected $repository;
    protected $controller;
    protected function setUp(): void
    {
        $this->repository = new PersonalidadeEloquentRepository(
            new Personalidade()
        );

        $this->controller = new PersonalidadeController();

        parent::setUp();
    }

    public function test_personalidade_index()
    {
        $usecase = new ListPersonalidadesUseCase($this->repository);

        $response = $this->controller->index(new Request(), $usecase);

        $this->assertInstanceOf(AnonymousResourceCollection::class, $response);
        $this->assertArrayHasKey('meta', $response->additional);

    }

    public function test_personalidade_store()
    {
        $usecase = new CreatePersonalidadeUseCase($this->repository);

        $request = new StorePersonalidadeRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag([
            'nome' => 'Teste',
        ]));

        $response = $this->controller->store($request, $usecase);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_CREATED, $response->status());

    }


    public function test_personalidade_show()
    {
        $personalidade = Personalidade::factory()->create();

        $response = $this->controller->show(
            usecase: new ListPersonalidadeUseCase($this->repository),
            id: $personalidade->id,
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
    }

    public function test_personalidade_update()
    {
        $personalidade = Personalidade::factory()->create();

        $request = new UpdatePersonalidadeRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag([
            'nome' => 'Updated',
        ]));

        $response = $this->controller->update(
            request: $request,
            usecase: new UpdatePersonalidadeUseCase($this->repository),
            id: $personalidade->id
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertDatabaseHas('personalidades', ['nome' => 'Updated']);
    }

    public function test_personalidade_delete()
    {
        $personalidade = Personalidade::factory()->create();

        $response = $this->controller->destroy(
            usecase: new DeletePersonalidadeUseCase($this->repository),
            id: $personalidade->id
        );

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->status());
        $this->assertDatabaseHas('personalidades', ['nome' => $personalidade->nome], false);
    }

}
