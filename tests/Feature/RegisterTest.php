<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * @test
     */
    public function is_can_register()
    {
        $data = [
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ];

        $this->json('POST', '/api/register', $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'api_token',
                'created_at',
                'updated_at'
            ]);
    }

    /**
     * @test
     */
    public function is_require_params()
    {
        $this->json('POST', '/api/register')
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                'errors' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }
}
