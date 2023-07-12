<?php

namespace Core\UseCase\DTO\Usuario;

use Core\Domain\Entity\Usuario\ValueObjects\Email;
use Core\Domain\Entity\Usuario\ValueObjects\Pessoa;
use Core\Domain\Entity\Usuario\ValueObjects\TipoUsuario;
use Core\Domain\Entity\Uuid;
use DateTime;

class UsuarioCreateDto
{
    public function __construct(
        public string $apelido,
        public Email $email,
        public TipoUsuario $tipo_usuario,
        public Pessoa $pessoa,
        public Uuid|string $id = '',
        public string $nome_usuario = '',
        public bool $eh_ativo = true,
        public DateTime|string $data_criacao = '',
    ) {}
}

