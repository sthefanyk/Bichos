<?php

namespace Core\UseCase\Usuario;

use Core\Domain\Entity\Usuario\PessoaFisica;
use Core\Domain\Entity\Usuario\ValueObjects\Cpf;
use Core\Domain\Entity\Usuario\ValueObjects\Email;
use Core\Domain\Entity\Usuario\ValueObjects\Pessoa;
use Core\Domain\Repository\UsuarioRepositoryInterface;

class CreateUsuarioUseCase
{
    protected $repository;
    public function __construct(UsuarioRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute()
    {
        $pessoa = new Pessoa(
            cpf: new Cpf('135.028.149-29'),
            nome_completo: 'nome completo',
            data_nascimento: '2002/02/27'
        );

        $usuario = new PessoaFisica(
            apelido: 'teste',
            email: new Email('email@gmail.com'),
            pessoa: $pessoa
        );

        $this->repository->insert($usuario);
    }
}

