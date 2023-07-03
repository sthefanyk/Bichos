<?php

namespace Core\Domain\Entity\Usuario\ValueObjects;

use Core\Domain\Entity\Traits\MethodMagicTrait;
use Core\Domain\Exception\EntityValidationException;

class Cpf
{
    use MethodMagicTrait;

    public function __construct(
        protected string $cpf,
    )
    {
        $this->validar();
    }

    private function validar()
    {
        $cpf = preg_replace( '/[^0-9]/is', '', $this->cpf);

        if (strlen($cpf) != 11) {
            throw new EntityValidationException("CPF deve conter 11 digitos!");
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            throw new EntityValidationException("Digito repetidos!");
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                throw new EntityValidationException("CPF inválido!");
            }
        }
    }
}
