<?php

namespace Tests\Unit\UseCase\Personalidade;

use Core\Domain\Entity\Personalidade;
use Core\Domain\Repository\PersonalidadeRepositoryInterface;
use Core\UseCase\DTO\Personalidade\Update\PersonalidadeUpdateInputDto;
use Core\UseCase\DTO\Personalidade\Update\PersonalidadeUpdateOutputDto;
use Core\UseCase\Personalidade\UpdatePersonalidadeUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Core\Domain\Entity\Uuid;
use Ramsey\Uuid\Uuid as RamseyUuid;
use stdClass;

class UpdatePersonalidadeUseCaseUnitTest extends TestCase
{
    public function test_personalidade_update_usecase()
    {
        $uuid = (string) RamseyUuid::uuid4();
        $personalidadeName = 'name cat';

        $mockEntity = Mockery::mock(Personalidade::class, [
            $personalidadeName, new Uuid($uuid)
        ]);
        $mockEntity->shouldReceive('atualizar');
        $mockEntity->shouldReceive('id')->andReturn($uuid);
        $mockEntity->shouldReceive('data_criacao')->andReturn(date('Y-m-d H:i:s'));

        $mockRepo = Mockery::mock(stdClass::class, PersonalidadeRepositoryInterface::class);
        $mockRepo->shouldReceive('findById')->andReturn($mockEntity);
        $mockRepo->shouldReceive('update')->andReturn($mockEntity);

        $mockInputDto = Mockery::mock(PersonalidadeUpdateInputDto::class, [
            $uuid,
            'new name',
        ]);

        $useCase = new UpdatePersonalidadeUseCase($mockRepo);
        $responseUseCase = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(PersonalidadeUpdateOutputDto::class, $responseUseCase);

        /**
         * Spies
         */
        $spy = Mockery::spy(stdClass::class, PersonalidadeRepositoryInterface::class);
        $spy->shouldReceive('findById')->andReturn($mockEntity);
        $spy->shouldReceive('update')->andReturn($mockEntity);
        $useCase = new UpdatePersonalidadeUseCase($spy);
        $responseUseCase = $useCase->execute($mockInputDto);
        $spy->shouldHaveReceived('findById');
        $spy->shouldHaveReceived('update');

        Mockery::close();
    }
}
