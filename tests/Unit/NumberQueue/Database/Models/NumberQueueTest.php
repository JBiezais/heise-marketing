<?php

namespace Tests\Unit\NumberQueue\Database\Models;

use App\NumberQueue\Database\Models\NumberQueue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NumberQueueTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_attributes(): void
    {
        $model = new NumberQueue;

        $this->assertSame(['value', 'created_at'], $model->getFillable());
    }

    public function test_table_name(): void
    {
        $model = new NumberQueue;

        $this->assertSame('number_queue', $model->getTable());
    }

    public function test_timestamps_disabled(): void
    {
        $model = new NumberQueue;

        $this->assertFalse($model->usesTimestamps());
    }

    public function test_can_create_record(): void
    {
        $model = NumberQueue::create([
            'value' => 42,
        ]);

        $this->assertSame(42, $model->value);
        $this->assertDatabaseHas('number_queue', ['value' => 42]);
    }
}
