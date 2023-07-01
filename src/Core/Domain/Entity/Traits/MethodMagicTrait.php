<?php 

namespace Core\Domain\Entity\Traits;

use Exception;

trait MethodMagicTrait
{
    public function __get($atributo)
    {
        if ($this->{$atributo}) {
            return $this->{$atributo};
        }

        $classe = get_class($this);
        throw new Exception("Atributo {$atributo} não encontra do na classe {$classe}!");
        
    }

}
