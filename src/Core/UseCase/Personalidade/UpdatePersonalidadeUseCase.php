<?php

namespace Core\UseCase\Personalidade;

use Core\Domain\Entity\Personalidade;
use Core\Domain\Repository\PersonalidadeRepositoryInterface;
use Core\UseCase\DTO\Personalidade\Update\PersonalidadeUpdateInputDto;
use Core\UseCase\DTO\Personalidade\Update\PersonalidadeUpdateOutputDto;

class UpdatePersonalidadeUseCase
{
    protected $repository;

    public function __construct(PersonalidadeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(PersonalidadeUpdateInputDto $input): PersonalidadeUpdateOutputDto
    {
        $personalidade = $this->repository->findById($input->id);

        $personalidade->atualizar(
            nome: $input->nome
        );

        $output = $this->repository->update($personalidade);

        return new PersonalidadeUpdateOutputDto(
            id: $output->id(),
            nome: $output->nome,
            eh_ativo: $output->eh_ativo,
            data_criacao: $output->data_criacao(),
        );
    }
}
