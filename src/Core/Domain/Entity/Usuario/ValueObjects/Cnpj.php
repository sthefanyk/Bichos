<?php

namespace Core\Domain\Entity\Usuario\ValueObjects;

use Core\Domain\Entity\Traits\MethodMagicTrait;
use Core\Domain\Exception\EntityValidationException;

class Cnpj
{
    use MethodMagicTrait;

    public function __construct(
        protected string $cnpj,
    )
    {
        $this->validar();
    }

    private function validar()
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $this->cnpj);

        if (strlen($cnpj) != 14) {
            throw new EntityValidationException("CNPJ deve conter 14 digitos!");
        }

        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            throw new EntityValidationException("Digito repetidos!");
        }

        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            throw new EntityValidationException("CNPJ inválido!");

        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if (!$cnpj[13] == ($resto < 2 ? 0 : 11 - $resto)) {
            throw new EntityValidationException("CNPJ inválido!");
        }
    }
}
