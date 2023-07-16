<?php

namespace Tests\Unit\UseCase\Personalidade;

use Core\Domain\Entity\Personalidade;
use Core\Domain\Repository\PersonalidadeRepositoryInterface;
use Core\UseCase\DTO\Personalidade\Create\PersonalidadeCreateInputDto;
use Core\UseCase\DTO\Personalidade\Create\PersonalidadeCreateOutputDto;
use Core\UseCase\Personalidade\CreatePersonalidadeUseCase;
use DateTime;
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
        $data = date('Y-m-d H:i:s');
        $personalidadeName = 'name cat';

        $mockUuid = Mockery::mock(Uuid::class, [
            $uuid
        ]);

        $mockEntity = Mockery::mock(Personalidade::class, [
            $personalidadeName, $mockUuid, false, null
        ]);
        $mockEntity->shouldReceive('id')->andReturn($mockUuid);
        $mockEntity->shouldReceive('data_criacao')->andReturn($data);

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
        $this->assertFalse($responseUseCase->eh_ativo);
        $this->assertNotEmpty($responseUseCase->data_criacao);

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
