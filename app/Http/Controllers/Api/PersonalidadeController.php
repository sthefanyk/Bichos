<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonalidadeRequest;
use App\Http\Requests\UpdatePersonalidadeRequest;
use App\Http\Resources\PersonalidadeResource;
use Core\UseCase\DTO\Personalidade\Create\PersonalidadeCreateInputDto;
use Core\UseCase\DTO\Personalidade\Listt\ListPersonalidadeInputDto;
use Core\UseCase\DTO\Personalidade\PersonalidadeInputDto;
use Core\UseCase\DTO\Personalidade\Update\PersonalidadeUpdateInputDto;
use Core\UseCase\Personalidade\CreatePersonalidadeUseCase;
use Core\UseCase\Personalidade\DeletePersonalidadeUseCase;
use Core\UseCase\Personalidade\ListPersonalidadesUseCase;
use Core\UseCase\Personalidade\ListPersonalidadeUseCase;
use Core\UseCase\Personalidade\UpdatePersonalidadeUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PersonalidadeController extends Controller
{
    public function index(Request $request, ListPersonalidadesUseCase $usecase)
    {
        $response = $usecase->execute(
            input: new ListPersonalidadeInputDto(
                filter: $request->get('filter', ''),
                order:  $request->get('order', 'DESC'),
                page: (int) $request->get('page', 1),
                total_page: (int) $request->get('total_page', 15)
            )
        );

        return PersonalidadeResource::collection(collect($response->items))
                                            ->additional([
                                                'meta' => [
                                                    'total' => $response->total,
                                                    'current_page' => $response->current_page,
                                                    'first_page' => $response->first_page,
                                                    'last_page' => $response->last_page,
                                                    'per_page' => $response->per_page,
                                                    'to' => $response->to,
                                                    'from' => $response->from,
                                                ]
                                            ]);
    }

    public function store(StorePersonalidadeRequest $request, CreatePersonalidadeUseCase $usecase)
    {
        $response = $usecase->execute(
            input: new PersonalidadeCreateInputDto(
                nome: $request->nome,
                eh_ativo: (bool) $request->eh_ativo ?? true,
            )
        );

        return (new PersonalidadeResource($response))
                    ->response()
                    ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ListPersonalidadeUseCase $usecase,  $id)
    {
        $response = $usecase->execute(new PersonalidadeInputDto($id));

        return (new PersonalidadeResource($response))->response();
    }

    public function update(UpdatePersonalidadeRequest $request, UpdatePersonalidadeUseCase $usecase, $id)
    {
        $response = $usecase->execute(
            input: new PersonalidadeUpdateInputDto(
                id: $id,
                nome: $request->nome,
                eh_ativo: (bool) $request->eh_ativo ?? true,
            )
        );

        return (new PersonalidadeResource($response))->response();
    }

    public function destroy(DeletePersonalidadeUseCase $usecase,  $id)
    {
        $usecase->execute(new PersonalidadeInputDto($id));

        return response()->noContent();
    }

}
