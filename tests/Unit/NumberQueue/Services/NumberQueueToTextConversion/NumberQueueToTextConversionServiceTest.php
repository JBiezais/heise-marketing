<?php

namespace Tests\Unit\NumberQueue\Services\NumberQueueToTextConversion;

use App\NumberQueue\Database\Models\NumberQueue;
use App\NumberQueue\Services\NumberQueueToTextConversion\Data\NumberQueueToTextConversionData;
use App\NumberQueue\Services\NumberQueueToTextConversion\Enums\NumberQueueLocaleEnum;
use App\NumberQueue\Services\NumberQueueToTextConversion\NumberQueueToTextConversionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NumberQueueToTextConversionServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_execute_returns_null_when_queue_empty(): void
    {
        $service = new NumberQueueToTextConversionService;
        $data = new NumberQueueToTextConversionData(locale: NumberQueueLocaleEnum::EN);

        $result = $service->execute($data);

        $this->assertNull($result);
    }

    public function test_execute_returns_converted_text_and_deletes_record(): void
    {
        NumberQueue::create(['value' => 42]);

        $service = new NumberQueueToTextConversionService;
        $data = new NumberQueueToTextConversionData(locale: NumberQueueLocaleEnum::EN);

        $result = $service->execute($data);

        $this->assertSame('Forty-two', $result);
        $this->assertDatabaseCount('number_queue', 0);
    }

    public function test_execute_returns_most_recent_record(): void
    {
        NumberQueue::create(['value' => 1]);
        NumberQueue::create(['value' => 2]);
        NumberQueue::create(['value' => 3]);

        $service = new NumberQueueToTextConversionService;
        $data = new NumberQueueToTextConversionData(locale: NumberQueueLocaleEnum::EN);

        $result = $service->execute($data);

        $this->assertSame('Three', $result);
        $this->assertDatabaseCount('number_queue', 2);
    }
}
