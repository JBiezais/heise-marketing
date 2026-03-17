<?php

namespace Tests\Feature\NumberQueue;

use App\NumberQueue\Database\Models\NumberQueue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NumberQueueShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_returns_404_when_queue_empty(): void
    {
        $response = $this->getJson('/api/numbers');

        $response->assertStatus(404)
            ->assertJson(['message' => 'No numbers available in queue']);
    }

    public function test_show_returns_converted_text_when_queue_has_items(): void
    {
        NumberQueue::create(['value' => 42]);

        $response = $this->getJson('/api/numbers');

        $response->assertStatus(200)
            ->assertJson(['text' => 'Forty-two']);
    }

    public function test_show_returns_most_recent_number_as_text(): void
    {
        NumberQueue::create(['value' => 1]);
        NumberQueue::create(['value' => 99]);

        $response = $this->getJson('/api/numbers');

        $response->assertStatus(200)
            ->assertJson(['text' => 'Ninety-nine']);
    }

    public function test_show_accepts_locale_parameter(): void
    {
        NumberQueue::create(['value' => 1]);

        $response = $this->getJson('/api/numbers?locale=en');

        $response->assertStatus(200)
            ->assertJson(['text' => 'One']);
    }

    public function test_show_validation_rejects_invalid_locale(): void
    {
        NumberQueue::create(['value' => 1]);

        $response = $this->getJson('/api/numbers?locale=invalid');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['locale']);
    }
}
