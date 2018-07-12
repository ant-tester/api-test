<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FillterTransaction;
use App\Http\Requests\StoreTransaction;
use App\Http\Requests\UpdateTransaction;
use App\Models\Customer;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;

class TransactionController extends Controller
{
    /**
     * Getting a transaction
     * @param Customer $customer
     * @param $transaction_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Customer $customer, $transaction_id)
    {
        try {
            $transaction = $customer->transactions()
                ->where('id', $transaction_id)
                ->firstOrFail();

            return response()->json([
                'transactionId' => $transaction->id,
                'amount' => $transaction->formatted_amount,
                'date' => $transaction->date
            ], 200);
        }
        catch (Exception $e) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }
    }

    /**
     * Getting transaction by filters
     * @param Customer $customer
     * @param FillterTransaction $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Customer $customer, FillterTransaction $request)
    {
        $query = $customer->transactions();

        if($request->has('amount')) {
            $query->where('amount', $request->amount);
        }
        if($request->has('date')) {
            $query->whereDate('created_at', Carbon::parse($request->date)->toDateString());
        }
        $total = $query->count();

        if($request->has('offset')) {
            $query->skip($request->input('offset', 0));
        }
        if($request->has('limit')) {
            $query->take($request->input('limit', 10));
        }

        $result = $query->get()->map(function($item){
            return [
                'transactionId' => $item->id,
                'amount' => $item->formatted_amount,
                'date' => $item->date
            ];
        });

        return response()->json([
            'items' => $result,
            'total' => $total
        ], 200);
    }

    /**
     * Adding a transaction
     * @param StoreTransaction $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTransaction $request)
    {
        $transaction = Transaction::create([
            'customer_id' => $request->customerId,
            'amount' => $request->amount
        ]);

        return response()->json([
            'transactionId' => $transaction->id,
            'customerId' => $transaction->customer_id,
            'amount' => $transaction->formatted_amount,
            'date' => $transaction->date
        ], 201);
    }

    /**
     * Updating a transaction
     * @param Transaction $transaction
     * @param UpdateTransaction $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Transaction $transaction, UpdateTransaction $request)
    {
        $transaction->update($request->only('amount'));

        return response()->json([
            'transactionId' => $transaction->id,
            'customerId' => $transaction->customer_id,
            'amount' => $transaction->formatted_amount,
            'date' => $transaction->date
        ], 200);
    }

    /**
     * Deleting a transaction
     * @param int $transaction_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($transaction_id)
    {
        try {
            $result = Transaction::where('id', $transaction_id)->delete();

            return response()->json(['message' => ($result ? 'success' : 'fail')], 200);
        }
        catch(Exception $e) {
            return response()->json(['message' => 'fail'], 404);
        }
    }
}
