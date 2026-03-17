<?php

namespace Tests\Unit\NumberQueue\Services\NumberQueueStore;

use App\NumberQueue\Services\NumberQueueStore\Data\NumberQueueStoreData;
use App\NumberQueue\Services\NumberQueueStore\NumberQueueStoreService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NumberQueueStoreServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_execute_creates_number_queue_record(): void
    {
        $service = new NumberQueueStoreService;
        $data = new NumberQueueStoreData(number: 123);

        $service->execute($data);

        $this->assertDatabaseHas('number_queue', ['value' => 123]);
    }

    public function test_execute_creates_multiple_records(): void
    {
        $service = new NumberQueueStoreService;

        $service->execute(new NumberQueueStoreData(number: 1));
        $service->execute(new NumberQueueStoreData(number: 2));

        $this->assertDatabaseCount('number_queue', 2);
        $this->assertDatabaseHas('number_queue', ['value' => 1]);
        $this->assertDatabaseHas('number_queue', ['value' => 2]);
    }
}
