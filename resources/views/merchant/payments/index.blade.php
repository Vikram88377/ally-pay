@extends('merchant.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h2>Payments</h2>
</div>

<form method="GET" class="row mt-4 mb-3">
    <div class="col-md-3">
        <select name="status" class="form-control">
            <option value="">All Status</option>

            <option value="pending"
                {{ request('status') === 'pending' ? 'selected' : '' }}>
                Pending
            </option>

            <option value="success"
                {{ request('status') === 'success' ? 'selected' : '' }}>
                Success
            </option>

            <option value="failed"
                {{ request('status') === 'failed' ? 'selected' : '' }}>
                Failed
            </option>

            <option value="cancelled"
                {{ request('status') === 'cancelled' ? 'selected' : '' }}>
                Cancelled
            </option>
        </select>
    </div>

    <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            Filter
        </button>

        <a href="{{ route('merchant.payments.index') }}"
           class="btn btn-secondary">
            Reset
        </a>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Payment Reference</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->order_id }}</td>

                    <td>
                        {{ $payment->payment_reference ?? '-' }}
                    </td>

                    <td>
                        ₹{{ number_format($payment->amount, 2) }}
                        {{ $payment->currency }}
                    </td>

                    <td>
                        <span class="badge
                            {{ $payment->status === 'success'
                                ? 'bg-success'
                                : ($payment->status === 'failed'
                                    ? 'bg-danger'
                                    : 'bg-secondary') }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>

                    <td>
                        {{ $payment->customer_name ?? '-' }}
                    </td>

                    <td>
                        {{ $payment->created_at->format('d M Y h:i A') }}
                    </td>

                    <td>
                        <a href="{{ route('merchant.payments.show', $payment->id) }}"
                           class="btn btn-sm btn-primary">
                            View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        No payment records found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $payments->links() }}
@endsection