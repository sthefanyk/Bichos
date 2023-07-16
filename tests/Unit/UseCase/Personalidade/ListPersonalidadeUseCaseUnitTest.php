<?php

namespace Tests\Unit\UseCase\Personalidade;

use Core\Domain\Entity\Personalidade;
use Core\Domain\Repository\PersonalidadeRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;
use Core\Domain\Entity\Uuid;
use Core\UseCase\DTO\Personalidade\PersonalidadeInputDto;
use Core\UseCase\DTO\Personalidade\PersonalidadeOutputDto;
use Core\UseCase\Personalidade\ListPersonalidadeUseCase;
use Ramsey\Uuid\Uuid as RamseyUuid;

class ListPersonalidadeUseCaseUnitTest extends TestCase
{

    public function test_personalidade_list_by_id_usecase()
    {

        $uuid = (string) RamseyUuid::uuid4();

        $mockEntity = Mockery::mock(Personalidade::class, [
            'test', new Uuid($uuid), false
        ]);
        $mockEntity->shouldReceive('id')->andReturn($uuid);
        $mockEntity->shouldReceive('data_criacao')->andReturn(date('Y-m-d H:i:s'));

        $mockRepo = Mockery::mock(stdClass::class, PersonalidadeRepositoryInterface::class);
        $mockRepo->shouldReceive('findById')->andReturn($mockEntity);

        $mockDtoInput = Mockery::mock(PersonalidadeInputDto::class, [
            $uuid
        ]);

        $useCase = new ListPersonalidadeUseCase($mockRepo);
        $response = $useCase->execute($mockDtoInput);

        $this->assertInstanceOf(PersonalidadeOutputDto::class, $response);

        Mockery::close();
    }

}
