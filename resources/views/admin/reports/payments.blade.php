
@extends('admin.layouts.app')

@section('content')
<a
    href="{{ route('admin.reports.transactions') }}"
    class="btn btn-outline-primary"
>
    Wallet Report
</a>
<div class="d-flex justify-content-between align-items-center">
    <h2>Payment Report</h2>

    <a
        href="{{ route('admin.reports.payments.export', request()->query()) }}"
        class="btn btn-success"
    >
        Export CSV
    </a>
</div>

<form method="GET" class="row mt-4 mb-3">
    <div class="col-md-3">
        <label class="form-label">Status</label>

        <select name="status" class="form-control">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                Pending
            </option>
            <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>
                Success
            </option>
            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>
                Failed
            </option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>
                Cancelled
            </option>
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label">From Date</label>

        <input
            type="date"
            name="from_date"
            value="{{ request('from_date') }}"
            class="form-control"
        >
    </div>

    <div class="col-md-3">
        <label class="form-label">To Date</label>

        <input
            type="date"
            name="to_date"
            value="{{ request('to_date') }}"
            class="form-control"
        >
    </div>

    <div class="col-md-3 d-flex align-items-end gap-2">
        <button class="btn btn-primary">
            Filter
        </button>

        <a
            href="{{ route('admin.reports.payments') }}"
            class="btn btn-secondary"
        >
            Reset
        </a>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Merchant</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Payment Reference</th>
                <th>Customer</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->order_id }}</td>

                    <td>
                        {{ $payment->merchant->business_name ?? '-' }}
                    </td>

                    <td>
                        ₹{{ number_format($payment->amount, 2) }}
                        {{ $payment->currency }}
                    </td>

                    <td>
                        {{ ucfirst($payment->status) }}
                    </td>

                    <td>
                        {{ $payment->payment_reference ?? '-' }}
                    </td>

                    <td>
                        {{ $payment->customer_name ?? '-' }}
                    </td>

                    <td>
                        {{ $payment->created_at->format('d M Y h:i A') }}
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