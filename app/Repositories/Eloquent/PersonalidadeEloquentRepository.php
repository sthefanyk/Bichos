<?php

namespace App\Repositories\Eloquent;

use App\Models\Personalidade as Model;
use App\Repositories\Presenters\PaginationPresenter;
use Core\Domain\Entity\Personalidade;
use Core\Domain\Entity\Uuid;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\PaginationInterface;
use Core\Domain\Repository\PersonalidadeRepositoryInterface;
use DateTime;

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
            'created_at' => $personalidade->data_criacao(),
        ]);

        return $this->toPersonalidade($personalidade);
    }

    public function findById(string $id): Personalidade
    {
        if (!$personalidade = $this->model->find($id)) {
            throw new NotFoundException('Personalidade Not Found');
        }

        return $this->toPersonalidade($personalidade);
    }

    public function findAll(string $filter = '', $order = 'DESC'): array
    {
        $result = $this->model
                        ->where(function ($query) use ($filter) {
                            if ($filter) {
                                $query->where('nome', 'LIKE', "%{$filter}%");
                            }
                        })
                        ->orderBy('nome', $order)
                        ->get();

        return $result->toArray();
    }

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $total_page = 15): PaginationInterface
    {
        
        $result = $this->model
                        ->where(function ($query) use ($filter) {
                            if ($filter) {
                                $query->where('nome', 'LIKE', "%{$filter}%");
                            }
                        })
                        ->orderBy('nome', $order)
                        ->paginate($total_page);

        return new PaginationPresenter($result);
    }

    public function update(Personalidade $personalidade): Personalidade
    {
        if (! $personalidadeDb = $this->model->find($personalidade->id())) {
            throw new NotFoundException('Personalidade Not Found');
        }

        $personalidadeDb->update([
            'nome' => $personalidade->nome,
            'eh_ativo' => $personalidade->eh_ativo,
        ]);

        $personalidadeDb->refresh();

        return $this->toPersonalidade($personalidadeDb);
    }

    public function delete(string $id): bool
    {
        if (! $personalidadeDb = $this->model->find($id)) {
            throw new NotFoundException();
        }

        return $personalidadeDb->delete();
    }

    private function toPersonalidade(object $object): Personalidade
    {
        $entity = new Personalidade(
            id: new Uuid($object->id),
            nome: $object->nome,
            data_criacao: new DateTime($object->created_at),
        );
        ((bool) $object->eh_ativo) ? $entity->ativar() : $entity->desativar();

        return $entity;
    }
}
