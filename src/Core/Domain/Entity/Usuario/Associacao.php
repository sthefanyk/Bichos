<?php

namespace Core\Domain\Entity\Usuario;

use Core\Domain\Entity\Usuario\ValueObjects\Cnpj;
use Core\Domain\Entity\Usuario\ValueObjects\Email;
use Core\Domain\Entity\Usuario\ValueObjects\TipoUsuario;
use Core\Domain\Entity\Uuid;
use Core\Domain\Validation\DomainValidation;
use DateTime;

class Associacao extends Usuario
{
    public function __construct(
        protected Cnpj $cnpj,
        protected string $nome_associacao,
        protected DateTime|string $data_registro,
        string $apelido,
        Email $email,
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
            tipo_usuario: TipoUsuario::ASSOCIACAO,
            eh_ativo: $eh_ativo
        );

        $this->validar();
    }

    public function atualizar(
        Cnpj $novo_cnpj = null,
        string $novo_nome_associacao = '',
        DateTime|string $nova_data_registro = null,
        string $novo_apelido = '',
        Email $novo_email = null,
        string $novo_nome_usuario = '',
    ){
        $this->cnpj = $novo_cnpj ? $novo_cnpj : $this->cnpj;
        $this->nome_associacao = $novo_nome_associacao ? $novo_nome_associacao : $this->nome_associacao;
        $this->data_registro = $nova_data_registro ? $nova_data_registro : $this->data_registro;
        $this->apelido = $novo_apelido ? $novo_apelido : $this->apelido;
        $this->nome_usuario = $novo_nome_usuario ? $novo_nome_usuario : $this->nome_usuario;
        $this->email = $novo_email ? $novo_email : $this->email;
        parent::validar();
        $this->validar();
    }

    public function validar()
    {
        if (!$this->data_registro instanceof DateTime) {
            $this->data_registro = new DateTime($this->data_registro);
        }

        DomainValidation::notNull($this->nome_associacao);
        DomainValidation::strMaxLength($this->nome_associacao, 100);
        DomainValidation::strMinLength($this->nome_associacao);
        DomainValidation::strClean($this->nome_associacao);

        DomainValidation::futureDate($this->data_registro);
    }
}
