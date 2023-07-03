<?php

namespace Core\Domain\Entity\Usuario\ValueObjects;

use Core\Domain\Entity\Traits\MethodMagicTrait;
use Core\Domain\Entity\Usuario\ValueObjects\Cpf;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use DateTime;

class Pessoa
{
    use MethodMagicTrait;

    public function __construct(
        protected Cpf $cpf,
        protected string $nome_completo,
        protected DateTime|string $data_nascimento,
    )
    {
        if (!$this->data_nascimento instanceof DateTime) {
            $this->data_nascimento = new DateTime($this->data_nascimento);
        }
        $this->validar();
    }

    private function validar()
    {
        DomainValidation::notNull($this->nome_completo);
        DomainValidation::strMinLength($this->nome_completo);
        DomainValidation::strMaxLength($this->nome_completo);
        DomainValidation::strClean($this->nome_completo);

        DomainValidation::futureDate($this->data_nascimento);

        $idade = $this->data_nascimento->diff(new DateTime())->y;
        if($idade < 18){
            throw new EntityValidationException("Idade menor que 18!");
        }
    }
}
