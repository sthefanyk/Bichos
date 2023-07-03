<?php

namespace Core\Domain\Entity\Usuario\ValueObjects;

use Core\Domain\Entity\Traits\MethodMagicTrait;
use Core\Domain\Exception\EntityValidationException;
use DateTime;

class Email
{
    use MethodMagicTrait;

    public function __construct(
        protected string $email,
        protected DateTime|string $data_validacao = '',
    )
    {
        $this->validar();
    }

    private function validar()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new EntityValidationException("Email inválido!");
        }
    }

    public function validarEmail(string $data_validacao = ''): DateTime
    {
        return $this->data_validacao = $data_validacao ? new DateTime($data_validacao) : new DateTime();
    }
}
