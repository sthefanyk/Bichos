<?php

namespace Core\UseCase\DTO\Personalidade\Create;

class PersonalidadeCreateInputDto
{
    public function __construct(
        public string $nome,
        public bool $eh_ativo = true,
    ) { }
}
