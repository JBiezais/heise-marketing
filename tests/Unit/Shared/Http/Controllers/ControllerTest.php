<?php

namespace Tests\Unit\Shared\Http\Controllers;

use App\Shared\Http\Controllers\Controller;
use PHPUnit\Framework\TestCase;

class ControllerTest extends TestCase
{
    public function test_concrete_controller_can_be_instantiated(): void
    {
        $controller = new class extends Controller {};

        $this->assertInstanceOf(Controller::class, $controller);
    }
}
