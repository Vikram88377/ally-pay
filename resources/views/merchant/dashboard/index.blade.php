@extends('merchant.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h2>Dashboard</h2>

        <p class="text-muted">
            Welcome, {{ auth()->user()->name }}
        </p>
    </div>

    <span class="badge bg-success">
        {{ ucfirst($merchant->status) }}
    </span>
</div>

<div class="row mt-4 g-3">

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Payments</h6>
                <h3>{{ $stats['total_payments'] }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Successful Payments</h6>
                <h3>{{ $stats['successful_payments'] }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Failed Payments</h6>
                <h3>{{ $stats['failed_payments'] }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Revenue</h6>
                <h3>
                    ₹{{ number_format($stats['total_revenue'], 2) }}
                </h3>
            </div>
        </div>
    </div>

</div>

<div class="row mt-4 g-3">

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Webhook Events</h6>
                <h3>{{ $stats['webhook_events'] }}</h3>
            </div>
        </div>
    </div>

</div>

<div class="card mt-4 shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">
            Recent Payments
        </h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Customer</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentPayments as $payment)
                        <tr>
                            <td>{{ $payment->order_id }}</td>

                            <td>
                                ₹{{ number_format($payment->amount, 2) }}
                            </td>

                            <td>
                                {{ ucfirst($payment->status) }}
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
                            <td colspan="5" class="text-center">
                                No payment records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection