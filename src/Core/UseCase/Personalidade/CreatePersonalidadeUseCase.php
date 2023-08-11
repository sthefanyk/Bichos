<?php

namespace Core\UseCase\Personalidade;

use Core\Domain\Entity\Personalidade;
use Core\Domain\Repository\PersonalidadeRepositoryInterface;
use Core\UseCase\DTO\Personalidade\Create\PersonalidadeCreateInputDto;
use Core\UseCase\DTO\Personalidade\Create\PersonalidadeCreateOutputDto;

class CreatePersonalidadeUseCase
{
    protected $repository;

    public function __construct(PersonalidadeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(PersonalidadeCreateInputDto $input): PersonalidadeCreateOutputDto
    {
        $personalidade = new Personalidade(
            nome: $input->nome,
            eh_ativo: $input->eh_ativo,
        );

        $output = $this->repository->insert($personalidade);

        return new PersonalidadeCreateOutputDto(
            id: $output->id(),
            nome: $output->nome,
            eh_ativo: $output->eh_ativo,
            created_at: $output->data_criacao(),
        );
    }
}
