<?php

namespace Core\UseCase\DTO\Personalidade;

class PersonalidadeOutputDto
{
    public function __construct(
        public string $id,
        public string $nome,
        public bool $eh_ativo = true,
        public string $data_criacao = '',
    ) {
    }
}

