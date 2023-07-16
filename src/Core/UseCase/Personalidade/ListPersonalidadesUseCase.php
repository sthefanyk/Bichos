<?php

namespace Core\UseCase\Personalidade;

use Core\Domain\Repository\PersonalidadeRepositoryInterface;
use Core\UseCase\DTO\Personalidade\Listt\{
    ListPersonalidadeInputDto,
    ListPersonalidadeOutputDto
};

class ListPersonalidadesUseCase
{
    public function __construct(
        protected PersonalidadeRepositoryInterface $repository
    ) {}

    public function execute(ListPersonalidadeInputDto $input): ListPersonalidadeOutputDto {

        $response = $this->repository->paginate(
            filter: $input->filter,
            order: $input->order,
            page: $input->page,
            total_page: $input->total_page,
        );

        return new ListPersonalidadeOutputDto(
            items: $response->items(),
            total: $response->total(),
            current_page: $response->current_page(),
            last_page: $response->last_page(),
            first_page: $response->first_page(),
            per_page: $response->per_page(),
            to: $response->to(),
            from: $response->from(),
        );
    }
}
