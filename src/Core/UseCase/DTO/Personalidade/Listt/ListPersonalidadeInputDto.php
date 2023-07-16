<?php

namespace Core\UseCase\DTO\Personalidade\Listt;

class ListPersonalidadeInputDto
{
    public function __construct(
        public string $filter = '',
        public string $order = 'DESC',
        public int $page = 1,
        public int $total_page = 15,
    ) {}
}
