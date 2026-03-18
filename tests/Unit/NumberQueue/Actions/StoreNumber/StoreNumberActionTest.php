<?php

namespace Tests\Unit\NumberQueue\Actions\StoreNumber;

use App\NumberQueue\Actions\StoreNumber\Data\StoreNumberData;
use App\NumberQueue\Actions\StoreNumber\StoreNumberAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreNumberActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_execute_creates_number_queue_record(): void
    {
        $action = new StoreNumberAction;
        $data = new StoreNumberData(number: 123);

        $action->execute($data);

        $this->assertDatabaseHas('number_queue', ['value' => 123]);
    }

    public function test_execute_creates_multiple_records(): void
    {
        $action = new StoreNumberAction;

        $action->execute(new StoreNumberData(number: 1));
        $action->execute(new StoreNumberData(number: 2));

        $this->assertDatabaseCount('number_queue', 2);
        $this->assertDatabaseHas('number_queue', ['value' => 1]);
        $this->assertDatabaseHas('number_queue', ['value' => 2]);
    }
}
