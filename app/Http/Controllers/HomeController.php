<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the transaction list.
     *
     * @param Request $request
     * @param null $page
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $page = 1)
    {
        $data['input'] = $request->only('customer_id', 'amount', 'date');
        $data['transactions'] = [];

        if(!empty($request->input('customer_id'))) {

            $perPage = 5;
            $client = new Client(['headers' => [ 'Accept' => 'application/json' ]]);

            try {
                $response = $client->get(url('/api/transactions/' . $request->customer_id), [
                    'query' => [
                        'api_token' => Auth::user()->api_token,
                        'amount' => $request->amount,
                        'date' => $request->date,
                        'limit' => $perPage,
                        'offset' => ($page - 1) * $perPage
                    ]
                ]);

                if($response->getStatusCode() == 200) {
                    $data['transactions'] = json_decode($response->getBody()->getContents(), true);
                    $data['transactions']['current'] = $page;
                    $data['transactions']['per_page'] = $perPage;
                }
                else {
                    $data = array_merge($data, json_decode($response->getBody()->getContents(), true));
                }
            }
            catch(ClientException $e) {
                $content = json_decode($e->getResponse()->getBody()->getContents(), true);
                $data = array_merge($data, $content);
            }
        }
        else {
            $data['message'] = 'Please enter Customer ID';
        }

        return view('home')->with($data);
    }
}
