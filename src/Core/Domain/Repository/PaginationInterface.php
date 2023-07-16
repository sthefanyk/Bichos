<?php

namespace Core\Domain\Repository;

interface PaginationInterface
{
    /**
     * @return stdClass[]
     */
    public function items(): array;
    public function total(): int;
    public function last_page(): int;
    public function first_page(): int;
    public function current_page(): int;
    public function per_page(): int;
    public function to(): int;
    public function from(): int;
}