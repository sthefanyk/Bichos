<?php

namespace Tests\Unit\App\Http\Controllers\Api;

use App\Http\Controllers\Api\PersonalidadeController;
use Core\UseCase\DTO\Personalidade\Listt\ListPersonalidadeOutputDto;
use Core\UseCase\Personalidade\ListPersonalidadesUseCase;
use Illuminate\Http\Request;
use Mockery;
use PHPUnit\Framework\TestCase;

class PersonalidadeControllerUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_personalidade_index()
    {
        $mockRequest = Mockery::mock(Request::class);
        $mockRequest->shouldReceive('get')->andReturn('/index');

        $mockDtoOutput = Mockery::mock(ListPersonalidadeOutputDto::class, [
            [], 1, 1, 1, 1, 1, 1, 1
        ]);

        $mockUseCase = Mockery::mock(ListPersonalidadesUseCase::class);
        $mockUseCase->shouldReceive('execute')->andReturn($mockDtoOutput);


        $controller = new PersonalidadeController();
        $response = $controller->index($mockRequest, $mockUseCase);

        $this->assertIsObject($response->resource);
        $this->assertArrayHasKey('meta', $response->additional);

        /**
         * Spies
         */
        $mockUseCaseSpy = Mockery::spy(ListPersonalidadesUseCase::class);
        $mockUseCaseSpy->shouldReceive('execute')->andReturn($mockDtoOutput);
        $controller->index($mockRequest, $mockUseCaseSpy);
        $mockUseCaseSpy->shouldReceive('execute');

        Mockery::close();
    }
}
