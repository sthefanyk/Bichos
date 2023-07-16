<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Uuid;
use Core\Domain\Entity\Traits\MethodMagicTrait;
use Core\Domain\Validation\DomainValidation;
use DateTime;

class Personalidade
{
    use MethodMagicTrait;

    public function __construct(
        protected string $nome,
        protected ?Uuid $id = null,
        protected bool $eh_ativo = true,
        protected ?DateTime $data_criacao = null,
    ) {
        $this->id = $this->id ?? Uuid::random();
        $this->data_criacao = $this->data_criacao ?? new DateTime();

        $this->validar();
    }

    public function ativar(){
        $this->eh_ativo = true;
    }

    public function desativar(){
        $this->eh_ativo = false;
    }

    public function atualizar(string $nome){
        $this->nome = $nome;

        $this->validar();
    }

    private function validar(){
        DomainValidation::strMinLength($this->nome);
        DomainValidation::strMaxLength($this->nome);
    }
}
