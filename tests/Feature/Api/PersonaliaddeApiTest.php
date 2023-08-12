<?php

namespace Tests\Feature\Api;

use App\Models\Personalidade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class PersonaliaddeApiTest extends TestCase
{
    protected $endpoint = '/api/personalidades';

    public function test_list_empty_personalidades()
    {
        $response = $this->getJson($this->endpoint);

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    public function test_list_all_personalidades()
    {
        Personalidade::factory()->count(30)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'current_page',
                'first_page',
                'last_page',
                'per_page',
                'to',
                'from'
            ]
        ]);
        $response->assertJsonCount(15, 'data');
    }

    public function test_list_paginate_personalidades()
    {
        Personalidade::factory()->count(25)->create();

        $response = $this->getJson("$this->endpoint?page=2");

        $response->assertStatus(200);
        $this->assertEquals(2, $response['meta']['current_page']);
        $this->assertEquals(25, $response['meta']['total']);
        $response->assertJsonCount(10, 'data');

    }

    public function test_list_not_found_personalidades()
    {
        $response = $this->getJson("$this->endpoint/fake_value");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_list_personalidades()
    {
        $personalidade = Personalidade::factory()->create();

        $response = $this->getJson("$this->endpoint/{$personalidade->id}");

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'nome',
                'eh_ativo',
                'created_at',
            ],
        ]);
        $this->assertEquals($personalidade->id, $response['data']['id']);
    }

    public function test_validations_store_personalidade()
    {
        $data = [];

        $response = $this->postJson($this->endpoint, $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'nome',
            ],
        ]);
    }

    public function test_store_personalidade()
    {
        $data = [
            'nome' => 'nova personalidade',
            'eh_ativo' => false,
        ];

        $response = $this->postJson($this->endpoint, $data);

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'nome',
                'eh_ativo',
                'created_at',
            ],
        ]);

        $this->assertEquals('nova personalidade', $response['data']['nome']);
        $this->assertEquals(false, $response['data']['eh_ativo']);

        $this->assertDatabaseHas('personalidades', [
            'id' => $response['data']['id'],
            'nome' => $response['data']['nome'],
            'eh_ativo' => false,
        ]);
    }

    public function test_not_found_update_personalidade()
    {
        $data = [
            'nome' => 'nova personalidade',
            'eh_ativo' => false,
        ];

        $response = $this->putJson("{$this->endpoint}/fake_id", $data);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_validations_update_personalidade()
    {
        $data = [];

        $personalidade = Personalidade::factory()->create();

        $response = $this->putJson("{$this->endpoint}/{$personalidade->id}", $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'nome',
            ],
        ]);
    }

    public function test_update_personalidade()
    {
        $data = [
            'nome' => 'nome atualizado'
        ];

        $personalidade = Personalidade::factory()->create();

        $response = $this->putJson("{$this->endpoint}/{$personalidade->id}", $data);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'nome',
                'eh_ativo',
                'created_at',
            ],
        ]);

        $this->assertDatabaseHas('personalidades', [
            'id' => $response['data']['id'],
            'nome' => 'nome atualizado',
            'eh_ativo' => true,
        ]);
    }

    public function test_not_found_delete_personalidade()
    {
        $response = $this->deleteJson("{$this->endpoint}/fake_id");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_delete_personalidade()
    {
        $personalidade = Personalidade::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/{$personalidade->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertSoftDeleted('personalidades', [
            'id' => $personalidade->id
        ]);
    }
}
