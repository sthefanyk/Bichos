<?php

namespace App\Repositories\Eloquent;

use App\Models\Personalidade as Model;
use App\Repositories\Presenters\PaginationPresenter;
use Core\Domain\Entity\Personalidade;
use Core\Domain\Repository\PaginationInterface;
use Core\Domain\Repository\PersonalidadeRepositoryInterface;

class PersonalidadeEloquentRepository implements PersonalidadeRepositoryInterface
{
    protected $model;

    public function __construct(Model $personalidade) {
        $this->model = $personalidade;
    }

    public function insert(Personalidade $personalidade): Personalidade
    {
        $personalidade = $this->model->create([
            'id' => $personalidade->id(),
            'nome' => $personalidade->nome,
            'eh_ativo' => $personalidade->eh_ativo,
            'data_criacao' => $personalidade->data_criacao(),
        ]);

        return $this->toPersonalidade($personalidade);
    }

    public function findById(string $id): Personalidade
    {
        return new Personalidade(
            nome: '$object->nome',
        );
    }

    public function findAll(string $filter = '', $order = 'DESC'): array
    {
        return [];
    }

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $total_page = 15): PaginationInterface
    {
        return new PaginationPresenter();
    }

    public function update(Personalidade $personalidade): Personalidade
    {
        return new Personalidade(
            nome: '$object->nome',
        );
    }

    public function delete(string $id): bool
    {
        return true;
    }

    private function toPersonalidade(object $object): Personalidade
    {
        return new Personalidade(
            nome: $object->nome,
        );
    }
}
