@extends('admin.layouts.app')

@section('content')
<h2>Wallet Transactions</h2>

<form method="GET" class="row mt-4 mb-3">
    <div class="col-md-3">
        <select name="type" class="form-control">
            <option value="">All Types</option>
            <option value="credit" {{ request('type') == 'credit' ? 'selected' : '' }}>Credit</option>
            <option value="debit" {{ request('type') == 'debit' ? 'selected' : '' }}>Debit</option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary">Filter</button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Balance After</th>
            <th>Reference</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->wallet->user->name ?? '-' }}</td>
                <td>{{ ucfirst($transaction->type) }}</td>
                <td>₹{{ $transaction->amount }}</td>
                <td>₹{{ $transaction->balance_after }}</td>
                <td>{{ $transaction->reference_id }}</td>
                <td>{{ ucfirst($transaction->status) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $transactions->links() }}
@endsection