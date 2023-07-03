<?php

namespace Core\Domain\Entity\Usuario;

use Core\Domain\Entity\Usuario\ValueObjects\Email;
use Core\Domain\Entity\Usuario\ValueObjects\Pessoa;
use Core\Domain\Entity\Usuario\ValueObjects\TipoUsuario;
use Core\Domain\Entity\Uuid;
use DateTime;

class PessoaFisica extends Usuario
{
    public function __construct(
        string $apelido,
        Email $email,
        protected Pessoa $pessoa,
        Uuid|string $id = '',
        string $nome_usuario = '',
        bool $eh_ativo = true,
        DateTime|string $data_criacao = '',
    )
    {
        parent::__construct(
            id: $id,
            apelido: $apelido,
            nome_usuario: $nome_usuario,
            email: $email,
            tipo_usuario: TipoUsuario::PESSOA_FISICA,
            eh_ativo: $eh_ativo,
            data_criacao: $data_criacao
        );
    }

    public function atualizar(
        string $novo_apelido = '',
        Email $novo_email = null,
        Pessoa $nova_pessoa = null,
        string $novo_nome_usuario = '',
        DateTime|string $data_criacao = '',
    )
    {
        $this->apelido = $novo_apelido ? $novo_apelido : $this->apelido;
        $this->nome_usuario = $novo_nome_usuario ? $novo_nome_usuario : $this->nome_usuario;
        $this->email = $novo_email ? $novo_email : $this->email;
        $this->pessoa = $nova_pessoa ? $nova_pessoa : $this->pessoa;
        $this->data_criacao = $data_criacao ? $data_criacao : $this->data_criacao;
        if (!$this->data_criacao instanceof DateTime) {
            $this->data_criacao = new DateTime($this->data_criacao);
        }
        parent::validar();
    }
}
