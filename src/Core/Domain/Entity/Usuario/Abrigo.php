<?php

namespace Core\Domain\Entity\Usuario;

use Core\Domain\Entity\Usuario\ValueObjects\Email;
use Core\Domain\Entity\Usuario\ValueObjects\Pessoa;
use Core\Domain\Entity\Usuario\ValueObjects\TipoUsuario;
use Core\Domain\Entity\Uuid;
use Core\Domain\Validation\DomainValidation;
use DateTime;

final class Abrigo extends Usuario
{
    public function __construct(
        string $apelido,
        Email $email,
        protected Pessoa $responsavel,
        protected string $nome_abrigo,
        protected DateTime|string $data_inicio,
        Uuid|string $id = '',
        string $nome_usuario = '',
        bool $eh_ativo = true,
    )
    {
        parent::__construct(
            id: $id,
            apelido: $apelido,
            nome_usuario: $nome_usuario,
            email: $email,
            tipo_usuario: TipoUsuario::ABRIGO,
            eh_ativo: $eh_ativo
        );
        $this->validar();
    }

    public function atualizar(
        string $novo_nome_abrigo = '',
        DateTime|string $nova_data_inicio = null,
        Pessoa $novo_responsavel = null,
        string $novo_apelido = '',
        Email $novo_email = null,
        string $novo_nome_usuario = '',
    ){
        $this->nome_abrigo = $novo_nome_abrigo ? $novo_nome_abrigo : $this->nome_abrigo;
        $this->data_inicio = $nova_data_inicio ? $nova_data_inicio : $this->data_inicio;
        $this->apelido = $novo_apelido ? $novo_apelido : $this->apelido;
        $this->nome_usuario = $novo_nome_usuario ? $novo_nome_usuario : $this->nome_usuario;
        $this->email = $novo_email ? $novo_email : $this->email;
        $this->responsavel = $novo_responsavel ? $novo_responsavel : $this->responsavel;
        parent::validar();
        $this->validar();
    }

    public function validar()
    {
        if (!$this->data_inicio instanceof DateTime) {
            $this->data_inicio = new DateTime($this->data_inicio);
        }

        DomainValidation::notNull($this->nome_abrigo);
        DomainValidation::strMaxLength($this->nome_abrigo);
        DomainValidation::strMinLength($this->nome_abrigo);
        DomainValidation::strClean($this->nome_abrigo);

        DomainValidation::futureDate($this->data_inicio);
    }
}
