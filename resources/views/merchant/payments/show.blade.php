@extends('merchant.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h2>Payment Detail</h2>

    <a href="{{ route('merchant.payments.index') }}"
       class="btn btn-secondary">
        Back
    </a>
</div>

<div class="card mt-4 shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p>
                    <strong>Order ID:</strong>
                    {{ $paymentOrder->order_id }}
                </p>

                <p>
                    <strong>Payment Reference:</strong>
                    {{ $paymentOrder->payment_reference ?? '-' }}
                </p>

                <p>
                    <strong>Amount:</strong>
                    ₹{{ number_format($paymentOrder->amount, 2) }}
                    {{ $paymentOrder->currency }}
                </p>

                <p>
                    <strong>Status:</strong>
                    {{ ucfirst($paymentOrder->status) }}
                </p>
            </div>

            <div class="col-md-6">
                <p>
                    <strong>Customer:</strong>
                    {{ $paymentOrder->customer_name ?? '-' }}
                </p>

                <p>
                    <strong>Email:</strong>
                    {{ $paymentOrder->customer_email ?? '-' }}
                </p>

                <p>
                    <strong>Phone:</strong>
                    {{ $paymentOrder->customer_phone ?? '-' }}
                </p>

                <p>
                    <strong>Created At:</strong>
                    {{ $paymentOrder->created_at->format('d M Y h:i A') }}
                </p>
            </div>
        </div>

        <hr>

        <p>
            <strong>Callback URL:</strong>
            {{ $paymentOrder->callback_url ?? '-' }}
        </p>

        <p><strong>Metadata:</strong></p>

        <pre class="bg-light border rounded p-3">{{ json_encode(
            $paymentOrder->metadata,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        ) }}</pre>
    </div>
</div>

<h4 class="mt-4">Webhook Logs</h4>

<div class="table-responsive mt-3">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Event</th>
                <th>Status</th>
                <th>Attempts</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>
            @forelse($paymentOrder->webhookEvents as $event)
                <tr>
                    <td>{{ $event->event_type }}</td>
                    <td>{{ ucfirst($event->status) }}</td>
                    <td>{{ $event->attempts }}</td>
                    <td>
                        {{ $event->created_at->format('d M Y h:i A') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">
                        No webhook logs found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection