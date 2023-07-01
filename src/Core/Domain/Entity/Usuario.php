<?php 

namespace Core\Domain\Entity;
use Core\Domain\Entity\Traits\MethodMagicTrait;

class Usuario
{
    use MethodMagicTrait;

    public function __construct(
        protected string $id,
        protected string $nome,
        protected string $apelido,
        protected string $email,
        protected string $tipo,
        protected string $eh_ativo,
    )
    {
        
    }
}
