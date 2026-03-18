<?php

namespace Tests\Unit\NumberQueue\Actions\ConvertNextNumber;

use App\NumberQueue\Actions\ConvertNextNumber\ConvertNextNumberAction;
use App\NumberQueue\Actions\ConvertNextNumber\Data\ConvertNextNumberData;
use App\NumberQueue\Actions\ConvertNextNumber\Enums\NumberQueueLocale;
use App\NumberQueue\Database\Models\NumberQueue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConvertNextNumberActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_execute_returns_null_when_queue_empty(): void
    {
        $action = new ConvertNextNumberAction;
        $data = new ConvertNextNumberData(locale: NumberQueueLocale::EN);

        $result = $action->execute($data);

        $this->assertNull($result);
    }

    public function test_execute_returns_converted_text_and_deletes_record(): void
    {
        NumberQueue::create(['value' => 42]);

        $action = new ConvertNextNumberAction;
        $data = new ConvertNextNumberData(locale: NumberQueueLocale::EN);

        $result = $action->execute($data);

        $this->assertSame('Forty-two', $result);
        $this->assertDatabaseCount('number_queue', 0);
    }

    public function test_execute_returns_most_recent_record(): void
    {
        NumberQueue::create(['value' => 1]);
        NumberQueue::create(['value' => 2]);
        NumberQueue::create(['value' => 3]);

        $action = new ConvertNextNumberAction;
        $data = new ConvertNextNumberData(locale: NumberQueueLocale::EN);

        $result = $action->execute($data);

        $this->assertSame('Three', $result);
        $this->assertDatabaseCount('number_queue', 2);
    }
}
