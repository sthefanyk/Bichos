<?php

namespace Core\UseCase\Personalidade;

use Core\Domain\Repository\PersonalidadeRepositoryInterface;
use Core\UseCase\DTO\Personalidade\PersonalidadeInputDto;
use Core\UseCase\DTO\Personalidade\PersonalidadeOutputDto;

class ListPersonalidadeUseCase
{
    public function __construct(
        protected PersonalidadeRepositoryInterface $repository
    ) {}

    public function execute(PersonalidadeInputDto $input) : PersonalidadeOutputDto {
        $response = $this->repository->findById(id: $input->id);

        return new PersonalidadeOutputDto(
            id: $response->id(),
            nome: $response->nome,
            eh_ativo: $response->eh_ativo,
            data_criacao: $response->data_criacao(),
        );
    }
}
