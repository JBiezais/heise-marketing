<?php

namespace Tests\Feature\NumberQueue;

use App\NumberQueue\Database\Models\NumberQueue;
use App\NumberQueue\Services\NumberQueueToTextConversion\NumberQueueToTextConversionService;
use Exception;
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

    public function test_show_returns_latvian_text_when_locale_is_lv(): void
    {
        NumberQueue::create(['value' => 42]);

        $response = $this->getJson('/api/numbers?locale=lv');

        $response->assertStatus(200)
            ->assertJson(['text' => 'Četrdesmit divi']);
    }

    public function test_show_validation_rejects_invalid_locale(): void
    {
        NumberQueue::create(['value' => 1]);

        $response = $this->getJson('/api/numbers?locale=invalid');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['locale']);
    }

    public function test_show_returns_422_when_service_throws_exception(): void
    {
        NumberQueue::create(['value' => 1]);

        $mock = \Mockery::mock(NumberQueueToTextConversionService::class);
        $mock->shouldReceive('execute')->once()->andThrow(new Exception('Database error'));
        $this->instance(NumberQueueToTextConversionService::class, $mock);

        $response = $this->getJson('/api/numbers');

        $response->assertStatus(422)
            ->assertJson(['message' => 'Something went wrong']);
    }
}
