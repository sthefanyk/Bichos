<?php

namespace App\Repositories\Presenters;

use Core\Domain\Repository\PaginationInterface;

class PaginationPresenter implements PaginationInterface
{
    public function items(): array
    {
        return [];
    }

    public function total(): int
    {
        return 1;
    }

    public function last_page(): int
    {
        return 1;
    }

    public function first_page(): int
    {
        return 1;
    }

    public function current_page(): int
    {
        return 1;
    }

    public function per_page(): int
    {
        return 1;
    }

    public function to(): int
    {
        return 1;
    }

    public function from(): int
    {
        return 1;
    }

}
