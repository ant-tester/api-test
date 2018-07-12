<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function is_require_auth()
    {
        $this->json('POST', '/api/customer')
            ->assertStatus(401);
    }

    /**
     * @test
     */
    public function is_store_require_params()
    {
        $header = [
            'Authorization' => 'Bearer '.$this->user->api_token
        ];

        $this->json('POST', '/api/customer', [], $header)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                'errors' => [
                    'name' => ['The name field is required.']
                ]
            ]);
    }

    /**
     * @test
     */
    public function is_can_store()
    {
        $header = [
            'Authorization' => 'Bearer '.$this->user->api_token
        ];

        $data = [
            'name' => 'Test',
            'cnp' => 123,
        ];

        $this->json('POST', '/api/customer', $data, $header)
            ->assertStatus(201)
            ->assertJsonStructure([
                'customerId',
            ]);
    }
}
