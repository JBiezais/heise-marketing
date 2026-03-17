<?php

namespace Tests\Feature\NumberQueue;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NumberQueueStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_adds_number_and_returns_201(): void
    {
        $response = $this->postJson('/api/numbers', [
            'number' => 42,
        ]);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Number added']);
        $this->assertDatabaseHas('number_queue', ['value' => 42]);
    }

    public function test_store_validation_requires_number(): void
    {
        $response = $this->postJson('/api/numbers', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['number']);
    }

    public function test_store_validation_requires_integer(): void
    {
        $response = $this->postJson('/api/numbers', [
            'number' => 'not-a-number',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['number']);
    }

    public function test_store_validation_requires_min_zero(): void
    {
        $response = $this->postJson('/api/numbers', [
            'number' => -1,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['number']);
    }

    public function test_store_accepts_zero(): void
    {
        $response = $this->postJson('/api/numbers', [
            'number' => 0,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('number_queue', ['value' => 0]);
    }
}
