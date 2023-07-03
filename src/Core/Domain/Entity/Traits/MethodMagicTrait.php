<?php

namespace Core\Domain\Entity\Traits;

use Exception;

trait MethodMagicTrait
{
    public function __get($atributo)
    {
        if ($this->{$atributo} || $this->{$atributo} == '') {
            return $this->{$atributo};
        }

        $classe = get_class($this);
        throw new Exception("Atributo {$atributo} não encontrado na classe {$classe}!");

    }

    public function id(): string
    {
        return (string) $this->id;
    }

    public function data_validacao(string $format = ''): string
    {
        if ($format) {
            return $this->data_validacao->format($format);
        }
        return $this->data_validacao->format('Y-m-d H:i:s');
    }

}
