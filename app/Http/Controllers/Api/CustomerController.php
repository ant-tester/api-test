<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomer;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Adding a customer
     * @param StoreCustomer $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCustomer $request)
    {
        $customer = Customer::create($request->only(['name', 'cnp']));

        return response()->json([
            'customerId' => $customer->id
        ], 201);
    }
}
