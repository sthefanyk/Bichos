<?php

namespace Tests\Unit\UseCase\Personalidade;

use Core\Domain\Entity\Personalidade;
use Core\Domain\Repository\PersonalidadeRepositoryInterface;
use Core\UseCase\DTO\Personalidade\Create\PersonalidadeCreateInputDto;
use Core\UseCase\DTO\Personalidade\Create\PersonalidadeCreateOutputDto;
use Core\UseCase\Personalidade\CreatePersonalidadeUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Core\Domain\Entity\Uuid;
use Ramsey\Uuid\Uuid as RamseyUuid;
use stdClass;

class CreatePersonalidadeUseCaseUnitTest extends TestCase
{
    public function test_personalidade_create_usecase()
    {
        $uuid = (string) RamseyUuid::uuid4();
        $personalidadeName = 'name cat';

        $mockEntity = Mockery::mock(Personalidade::class, [
            $personalidadeName, new Uuid($uuid)
        ]);
        $mockEntity->shouldReceive('id')->andReturn($uuid);
        $mockEntity->shouldReceive('data_criacao')->andReturn(date('Y-m-d H:i:s'));

        $mockRepo = Mockery::mock(stdClass::class, PersonalidadeRepositoryInterface::class);
        $mockRepo->shouldReceive('insert')->andReturn($mockEntity);

        $mockInputDto = Mockery::mock(PersonalidadeCreateInputDto::class, [
            $personalidadeName,
        ]);

        $useCase = new CreatePersonalidadeUseCase($mockRepo);
        $responseUseCase = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(PersonalidadeCreateOutputDto::class, $responseUseCase);
        $this->assertNotEmpty($responseUseCase->id);
        $this->assertEquals($personalidadeName, $responseUseCase->nome);
        $this->assertTrue($responseUseCase->eh_ativo);
        $this->assertNotEmpty($responseUseCase->created_at);

        /**
         * Spies
         */
        $spy = Mockery::spy(stdClass::class, PersonalidadeRepositoryInterface::class);
        $spy->shouldReceive('insert')->andReturn($mockEntity);
        $useCase = new CreatePersonalidadeUseCase($spy);
        $responseUseCase = $useCase->execute($mockInputDto);
        $spy->shouldHaveReceived('insert');

        Mockery::close();
    }
}
