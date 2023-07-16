<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Personalidade;

interface PersonalidadeRepositoryInterface
{
    public function insert(Personalidade $personalidade): Personalidade;
    public function findById(string $id): Personalidade;
    public function findAll(string $filter = '', $order = 'DESC'): array;
    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $total_page = 15): PaginationInterface;
    public function update(Personalidade $personalidade): Personalidade;
    public function delete(string $id): bool;
    public function toPersonalidade(object $data): Personalidade;
}

