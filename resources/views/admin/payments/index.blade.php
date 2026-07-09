@extends('admin.layouts.app')

@section('content')
<h2>Payments</h2>

<form method="GET" class="row mt-4 mb-3">
    <div class="col-md-3">
        <select name="status" class="form-control">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="success">Success</option>
            <option value="failed">Failed</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary">Filter</button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Merchant</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Payment Ref</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->order_id }}</td>
                <td>{{ $payment->merchant->business_name ?? '-' }}</td>
                <td>{{ $payment->amount }} {{ $payment->currency }}</td>
                <td>{{ ucfirst($payment->status) }}</td>
                <td>{{ $payment->payment_reference ?? '-' }}</td>
                <td>
                    <a href="{{ route('admin.payments.show', $payment->id) }}"
                       class="btn btn-sm btn-primary">
                        View
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $payments->links() }}
@endsection