<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'name',
                'email',
                'role',
                'created_at',
                'updated_at',
            ],
        ]);
    }
    /** @test */
    public function a_user_can_login()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'token',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }
}
