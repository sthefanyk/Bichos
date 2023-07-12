<?php

namespace Test\Unit\UseCase;

use Core\Domain\Entity\Usuario\PessoaFisica;
use Core\Domain\Entity\Usuario\Usuario;
use Core\Domain\Entity\Usuario\ValueObjects\Cpf;
use Core\Domain\Entity\Usuario\ValueObjects\Email;
use Core\Domain\Entity\Usuario\ValueObjects\Pessoa;
use Core\Domain\Entity\Usuario\ValueObjects\TipoUsuario;
use Core\Domain\Repository\UsuarioRepositoryInterface;
use Core\UseCase\Usuario\CreateUsuarioUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class CreateUsuarioUseCaseUnitTest extends TestCase
{
    protected $mockEntity;
    protected $mockRepo;

    public function test_create_use_case()
    {
        $usuarioEmail = new Email("email@example.com");
        $usuarioCpf = new Cpf('135.028.149-29');
        $usuarioPessoa = new Pessoa(
            cpf: $usuarioCpf,
            nome_completo: 'nome completo',
            data_nascimento: '2002/02/27'
        );
        $usuarioApelido = 'apelido';
        $usuarioTipo = TipoUsuario::PESSOA_FISICA;

        $this->mockEntity = Mockery::mock(Usuario::class, [
            $usuarioApelido,
            $usuarioEmail,
            $usuarioTipo,
            //$usuarioPessoa,
        ]);

        $this->mockRepo = Mockery::mock(new stdClass(), UsuarioRepositoryInterface::class);
        $this->mockRepo->shouldReceive('insert')->andReturn($this->mockEntity);

        $usecase = new CreateUsuarioUseCase($this->mockRepo);
        $usecase->execute();

        $this->assertTrue(true);

        Mockery::close();
    }
}
