<?php

namespace Core\UseCase\Personalidade;

use Core\Domain\Repository\PersonalidadeRepositoryInterface;
use Core\UseCase\DTO\Personalidade\PersonalidadeInputDto;
use Core\UseCase\DTO\Personalidade\Delete\PersonalidadeDeleteOutputDto;

class DeletePersonalidadeUseCase
{
    protected $repository;

    public function __construct(PersonalidadeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(PersonalidadeInputDto $input): PersonalidadeDeleteOutputDto
    {
        $responseDelete = $this->repository->delete($input->id);

        return new PersonalidadeDeleteOutputDto(
            success: $responseDelete
        );
    }
}