<?php

namespace Tests\Unit\UseCase\Personalidade;

use Core\Domain\Repository\PersonalidadeRepositoryInterface;
use Core\UseCase\DTO\Personalidade\Delete\PersonalidadeDeleteOutputDto;
use Core\UseCase\DTO\Personalidade\PersonalidadeInputDto;
use Core\UseCase\Personalidade\DeletePersonalidadeUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;
use stdClass;

class DeletePersonalidadeUseCaseUnitTest extends TestCase
{
    public function test_personalidade_delete_true_usecase()
    {
        $uuid = (string) RamseyUuid::uuid4();

        $mockRepo = Mockery::mock(stdClass::class, PersonalidadeRepositoryInterface::class);
        $mockRepo->shouldReceive('delete')->andReturn(true);

        $mockInputDto = Mockery::mock(PersonalidadeInputDto::class, [$uuid]);

        $useCase = new DeletePersonalidadeUseCase($mockRepo);
        $responseUseCase = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(PersonalidadeDeleteOutputDto::class, $responseUseCase);
        $this->assertTrue($responseUseCase->success);

        /**
         * Spies
         */
        $spy = Mockery::spy(stdClass::class, PersonalidadeRepositoryInterface::class);
        $spy->shouldReceive('delete')->andReturn(true);
        $useCase = new DeletePersonalidadeUseCase($spy);
        $responseUseCase = $useCase->execute($mockInputDto);
        $spy->shouldHaveReceived('delete');
    }

    public function test_personalidade_delete_false_usecase()
    {
        $uuid = (string) RamseyUuid::uuid4();

        $mockRepo = Mockery::mock(stdClass::class, PersonalidadeRepositoryInterface::class);
        $mockRepo->shouldReceive('delete')->andReturn(false);

        $mockInputDto = Mockery::mock(PersonalidadeInputDto::class, [$uuid]);

        $useCase = new DeletePersonalidadeUseCase($mockRepo);
        $responseUseCase = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(PersonalidadeDeleteOutputDto::class, $responseUseCase);
        $this->assertFalse($responseUseCase->success);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
