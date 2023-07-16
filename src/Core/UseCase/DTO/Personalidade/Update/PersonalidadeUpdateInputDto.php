<?php

namespace Core\UseCase\DTO\Personalidade\Update;

class PersonalidadeUpdateInputDto
{
    public function __construct(
        public string $id,
        public string $nome,
        public bool $eh_ativo = true,
    ) {
    }
}