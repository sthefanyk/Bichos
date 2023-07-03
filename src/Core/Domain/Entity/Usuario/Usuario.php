<?php

namespace Core\Domain\Entity\Usuario;

use Core\Domain\Entity\Traits\MethodMagicTrait;
use Core\Domain\Entity\Usuario\ValueObjects\Email;
use Core\Domain\Entity\Usuario\ValueObjects\TipoUsuario;
use Core\Domain\Entity\Uuid;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;

abstract class Usuario
{
    use MethodMagicTrait;

    public function __construct(
        protected string $apelido,
        protected Email $email,
        protected TipoUsuario $tipo_usuario,
        protected Uuid|string $id = '',
        protected string $nome_usuario = '',
        protected bool $eh_ativo = true,
    )
    {
        $this->nome_usuario = $this->nome_usuario ? $this->nome_usuario : $this->apelido;
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->validar();
    }

    public function ativar_usuario()
    {
        $this->eh_ativo = true;
    }

    public function desativar_usuario()
    {
        $this->eh_ativo = false;
    }

    protected function validar()
    {
        DomainValidation::notNull($this->apelido);
        DomainValidation::strMaxLength($this->apelido, 25);
        DomainValidation::strMinLength($this->apelido);

        $regex = "/^[A-Za-z]+$/";
        if (!preg_match($regex, $this->apelido)) {
            throw new EntityValidationException("Apelido inválido!");
        }

        DomainValidation::notNull($this->nome_usuario);
        DomainValidation::strMaxLength($this->nome_usuario, 25);
        DomainValidation::strMinLength($this->nome_usuario);
    }
}
