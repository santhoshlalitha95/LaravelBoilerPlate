<?php

namespace Tests\Feature\Auth;

use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLoginWithEmailAndPassword(): void
    {
        $user = $this->createUser(['password' => Hash::make('password')]);

        $reponse = $this->postJson(route('user.login', ['email' => $user->email, 'password' => 'password']))
            ->assertOk();

        $this->assertArrayHasKey('token', $reponse->json());
    }

    public function testEmailNotAvailable(): void
    {
        $user = $this->makeUser(['password' => Hash::make('password')]);
        $reponse = $this->postJson(route('user.login', ['email' => $user->email, 'password' => 'password']))
            ->assertUnauthorized();

    }
}
