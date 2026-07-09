@extends('admin.layouts.app')

@section('content')
<h2>Wallets</h2>

<a href="{{ route('admin.wallets.transactions') }}" class="btn btn-primary mt-3 mb-3">
    View Transactions
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Email</th>
            <th>Balance</th>
            <th>Created</th>
        </tr>
    </thead>

    <tbody>
        @foreach($wallets as $wallet)
            <tr>
                <td>{{ $wallet->id }}</td>
                <td>{{ $wallet->user->name ?? '-' }}</td>
                <td>{{ $wallet->user->email ?? '-' }}</td>
                <td>₹{{ $wallet->balance }}</td>
                <td>{{ $wallet->created_at->format('d M Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $wallets->links() }}
@endsection