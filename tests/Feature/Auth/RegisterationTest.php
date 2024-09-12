<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterationTest extends TestCase
{
    use RefreshDatabase;

    public function test_example(): void
    {
        $user = $this->makeUser(['password' => 'password']);
        $this->postJson(route('user.register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password,
        ]))->assertCreated();
        $this->assertDatabaseHas('users', ['email' => $user->email]);
    }
}
