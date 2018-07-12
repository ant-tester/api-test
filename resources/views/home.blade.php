@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form method="get" class="form-horizontal">
                        {{ csrf_field() }}
                        <h4>Set customer ID to view its transactions</h4>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Customer ID</label>
                            <div class="col-sm-10">
                                <input type="text" name="customer_id" class="form-control" placeholder="12" value="{{ array_get($input, 'customer_id') }}">
                            </div>
                        </div>
                        <hr>
                        <h4>Filter it</h4>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Amount</label>
                            <div class="col-sm-10">
                                <input type="text" name="amount" class="form-control" placeholder="22.00" value="{{ array_get($input, 'amount') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Date</label>
                            <div class="col-sm-10">
                                <input type="text" name="date" class="form-control" placeholder="12.01.2018" value="{{ array_get($input, 'date') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Search</button>
                            </div>
                        </div>
                    </form>

                    @if(!empty($message))
                        <div class="alert alert-info" role="alert">
                            {{ $message }}

                            @if(!empty($errors))
                                <ul>
                                    @foreach(array_flatten($errors) as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endif
                </div>

                @if(count(array_get($transactions, 'items', [])) > 0)
                    <div class="panel-body">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions['items'] as $item)
                                    <tr>
                                        <th scope="row">{{ $item['transactionId'] }}</th>
                                        <td>{{ $item['amount'] }}</td>
                                        <td>{{ $item['date'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <nav>
                            <ul class="pager">
                                <li class="previous @if($transactions['current'] <= 1) disabled @endif">
                                    <a href="{{ route('home', array_merge($input, ['page' => $transactions['current']-1])) }}"><span aria-hidden="true">&larr;</span> Older</a>
                                </li>
                                <li class="next @if($transactions['current']*$transactions['per_page'] >= $transactions['total']) disabled @endif">
                                    <a href="{{ route('home', array_merge($input, ['page' => $transactions['current']+1])) }}">Newer <span aria-hidden="true">&rarr;</span></a>
                                </li>
                            </ul>
                        </nav>

                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
