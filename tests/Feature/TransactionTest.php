<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Customer
     */
    protected $customer;

    /**
     * @var Transaction
     */
    protected $transaction;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->customer = factory(Customer::class)->create();
        $this->transaction = factory(Transaction::class)->create();
    }

    /**
     * @test
     */
    public function is_require_auth()
    {
        $this->json('POST', '/api/transaction')
            ->assertStatus(401);

        $this->json('GET', '/api/transaction/1/1')
            ->assertStatus(401);

        $this->json('PUT', '/api/transaction/1')
            ->assertStatus(401);

        $this->json('DELETE', '/api/transaction/1')
            ->assertStatus(401);

        $this->json('GET', '/api/transactions/1')
            ->assertStatus(401);
    }

    /*
     * Store
     */

    /**
     * @test
     */
    public function is_store_require_params()
    {
        $header = [
            'Authorization' => 'Bearer '.$this->user->api_token
        ];

        $this->json('POST', '/api/transaction', [], $header)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                'errors' => [
                    'customerId' => ['The customer id field is required.'],
                    'amount' => ['The amount field is required.']
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
            'customerId' => $this->customer->id,
            'amount' => 10.00
        ];

        $this->json('POST', '/api/transaction', $data, $header)
            ->assertStatus(201)
            ->assertJsonStructure([
                'transactionId',
                'customerId',
                'amount',
                'date'
            ]);
    }

    /*
     * Update
     */

    /**
     * @test
     */
    public function is_update_require_params()
    {
        $header = [
            'Authorization' => 'Bearer '.$this->user->api_token
        ];

        $this->json('PUT', '/api/transaction/'.$this->transaction->id, [], $header)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                'errors' => [
                    'amount' => ['The amount field is required.']
                ]
            ]);
    }

    /**
     * @test
     */
    public function is_can_update()
    {
        $header = [
            'Authorization' => 'Bearer '.$this->user->api_token
        ];

        $data = [
            'amount' => 10.00
        ];

        $this->json('PUT', '/api/transaction/'.$this->transaction->id, $data, $header)
            ->assertStatus(200)
            ->assertJsonStructure([
                'transactionId',
                'customerId',
                'amount',
                'date'
            ]);
    }

    /*
     * Delete
     */

    /**
     * @test
     */
    public function is_can_delete()
    {
        $header = [
            'Authorization' => 'Bearer '.$this->user->api_token
        ];

        $this->json('DELETE', '/api/transaction/'.$this->transaction->id, [], $header)
            ->assertStatus(200)
            ->assertJson([
                "message" => "success"
            ]);
    }


    /*
     * Show
     */

    /**
     * @test
     */
    public function is_can_show()
    {
        $header = [
            'Authorization' => 'Bearer '.$this->user->api_token
        ];

        $transaction = factory(Transaction::class)->create(['customer_id' => $this->customer->id]);

        $this->json('GET', '/api/transaction/'.$this->customer->id.'/'.$transaction->id, [], $header)
            ->assertStatus(200)
            ->assertJsonStructure([
                'transactionId',
                'amount',
                'date'
            ]);
    }

    /**
     * @test
     */
    public function is_can_filter()
    {
        $header = [
            'Authorization' => 'Bearer '.$this->user->api_token
        ];

        $transaction = factory(Transaction::class)->create(['customer_id' => $this->customer->id]);

        $this->json('GET', '/api/transactions/'.$this->customer->id, [], $header)
            ->assertStatus(200)
            ->assertJson([
                'total' => 1,
                'items' => [
                    [
                        'transactionId' => $transaction->id,
                        'amount' => $transaction->formatted_amount,
                        'date' => $transaction->date
                    ]
                ]
            ]);
    }

}
