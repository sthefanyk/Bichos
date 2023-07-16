<?php

namespace Tests\Unit\UseCase\Personalidade;

use Core\Domain\Repository\PaginationInterface;
use Core\Domain\Repository\PersonalidadeRepositoryInterface;
use Core\UseCase\DTO\Personalidade\Listt\ListPersonalidadeInputDto;
use Core\UseCase\DTO\Personalidade\Listt\ListPersonalidadeOutputDto;
use Core\UseCase\Personalidade\ListPersonalidadesUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListPersonalidadesUseCaseUnitTest extends TestCase
{

    public function test_personalidade_list_vazia_usecase()
    {
        $mockRepo = Mockery::mock(stdClass::class, PersonalidadeRepositoryInterface::class);
        $mockRepo->shouldReceive('paginate')->andReturn($this->mockPagination());

        $mockDtoInput = Mockery::mock(ListPersonalidadeInputDto::class, [
            'test', 'desc', 1, 15
        ]);

        $useCase = new ListPersonalidadesUseCase($mockRepo);
        $response = $useCase->execute($mockDtoInput);

        $this->assertInstanceOf(ListPersonalidadeOutputDto::class, $response);
        $this->assertCount(0, $response->items);

        /**
         * Spies
         */
        // arrange
        $spy = Mockery::spy(stdClass::class, PersonalidadeRepositoryInterface::class);
        $spy->shouldReceive('paginate')->andReturn($this->mockPagination());
        $sut = new ListPersonalidadesUseCase($spy);

        // action
        $sut->execute($mockDtoInput);

        // assert
        $spy->shouldHaveReceived()->paginate(
            'test', 'desc', 1, 15
        );
    }

    public function test_personalidade_list_usecase()
    {
        $register = new stdClass();
        $register->id = 'id';
        $register->nome = 'nome';
        $register->eh_ativo = 'eh_ativo';
        $register->data_criacao = 'data_criacao';

        $mockPagination = $this->mockPagination([
            $register
        ]);
        $mockRepo = Mockery::mock(stdClass::class, PersonalidadeRepositoryInterface::class);
        $mockRepo->shouldReceive('paginate')->andReturn($mockPagination);

        $mockDtoInput = Mockery::mock(ListPersonalidadeInputDto::class, [
            'test', 'desc', 1, 15
        ]);

        $useCase = new ListPersonalidadesUseCase($mockRepo);
        $response = $useCase->execute($mockDtoInput);

        $this->assertInstanceOf(ListPersonalidadeOutputDto::class, $response);
        $this->assertInstanceOf(stdClass::class, $response->items[0]);
        $this->assertCount(1, $response->items);
    }

    protected function mockPagination(array $items = [])
    {
        $mockPagination = Mockery::mock(stdClass::class, PaginationInterface::class);
        $mockPagination->shouldReceive('items')->andReturn($items);
        $mockPagination->shouldReceive('total')->andReturn(0);
        $mockPagination->shouldReceive('current_page')->andReturn(0);
        $mockPagination->shouldReceive('first_page')->andReturn(0);
        $mockPagination->shouldReceive('last_page')->andReturn(0);
        $mockPagination->shouldReceive('per_page')->andReturn(0);
        $mockPagination->shouldReceive('to')->andReturn(0);
        $mockPagination->shouldReceive('from')->andReturn(0);

        return $mockPagination;
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
