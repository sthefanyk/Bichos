<?php

namespace Core\UseCase\DTO\Personalidade\Delete;

class PersonalidadeDeleteOutputDto
{
    public function __construct(
        public bool $success
    ) {
    }
}