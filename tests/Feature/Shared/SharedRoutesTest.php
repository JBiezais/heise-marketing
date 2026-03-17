<?php

namespace Tests\Feature\Shared;

use Tests\TestCase;

class SharedRoutesTest extends TestCase
{
    public function test_welcome_route_returns_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_welcome_route_returns_welcome_view(): void
    {
        $response = $this->get('/');

        $response->assertViewIs('welcome');
    }
}
