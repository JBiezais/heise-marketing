<?php

namespace Tests\Unit\User\Database\Models;

use App\User\Database\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_attributes_are_mass_assignable(): void
    {
        $user = new User([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'secret',
        ]);

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertSame(['name', 'email', 'password'], $user->getFillable());
    }

    public function test_hidden_attributes_are_not_in_array_representation(): void
    {
        $user = User::factory()->create();

        $array = $user->toArray();

        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
    }

    public function test_password_is_hashed_via_casts(): void
    {
        $user = new User([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'plaintext',
        ]);

        $user->save();

        $this->assertNotSame('plaintext', $user->password);
        $this->assertTrue(Hash::check('plaintext', $user->password));
    }

    public function test_email_verified_at_is_cast_to_datetime(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => '2024-01-15 12:00:00',
        ]);

        $this->assertInstanceOf(\DateTimeInterface::class, $user->email_verified_at);
        $this->assertSame('2024-01-15 12:00:00', $user->email_verified_at->format('Y-m-d H:i:s'));
    }

    public function test_factory_creates_valid_user(): void
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
        ]);
        $this->assertNotNull($user->name);
        $this->assertNotNull($user->email);
        $this->assertTrue(Hash::check('password', $user->password));
    }

    public function test_user_extends_authenticatable(): void
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Authenticatable::class, $user);
    }

    public function test_user_uses_notifiable_trait(): void
    {
        $user = User::factory()->create();

        $this->assertTrue(method_exists($user, 'notify'));
        $this->assertTrue(method_exists($user, 'routeNotificationFor'));
    }
}
