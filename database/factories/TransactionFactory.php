<?php

use App\Models\Customer;
use App\Models\Transaction;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'customer_id' => factory(Customer::class)->create()->id,
        'amount' => 10.00,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ];
});
