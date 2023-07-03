<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Usuario\Usuario;

interface UsuarioRepositoryInterface
{
    public function insert(Usuario $usuario);
    public function findById(string $id): Usuario;
    public function findAll(string $filter = '', $order = 'DESC'): array;
    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): array;
    public function update(Usuario $usuario): Usuario;
    public function delete(string $id): bool;
    public function toUsuario(object $data): Usuario;
}

