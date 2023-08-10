<?php

namespace App\Repositories\Presenters;

use Core\Domain\Repository\PaginationInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use stdClass;

class PaginationPresenter implements PaginationInterface
{
    /**
     * @return stdClass[]
     */
    protected array $items = [];

    public function __construct(
        protected LengthAwarePaginator $paginator
    ) {
        $this->resolveItems(
            items: $this->paginator->items()
        );
    }

    /**
     * @return stdClass[]
     */
    public function items(): array
    {
        return $this->items;
    }

    public function total(): int
    {
        return $this->paginator->total();
    }

    public function last_page(): int
    {
        return $this->paginator->lastPage();
    }

    public function first_page(): int
    {
        return (int) $this->paginator->firstItem();

    }

    public function current_page(): int
    {
        return $this->paginator->currentPage();
    }

    public function per_page(): int
    {
        return $this->paginator->perPage();
    }

    public function to(): int
    {
        return (int) $this->paginator->firstItem();
    }

    public function from(): int
    {
        return (int) $this->paginator->lastItem();
    }

    protected function resolveItems(array $items)
    {
        $response = [];

        foreach ($items as $item) {
            $stdClass = new stdClass;
            foreach ($item->toArray() as $key => $value) {
                $stdClass->{$key} = $value;
            }

            array_push($response, $stdClass);
        }

        return $this->items = $response;
    }

}
