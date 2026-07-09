@extends('admin.layouts.app')

@section('content')
<h2>Payment Detail</h2>

<div class="card mt-4">
    <div class="card-body">
        <p><strong>Order ID:</strong> {{ $paymentOrder->order_id }}</p>
        <p><strong>Payment Ref:</strong> {{ $paymentOrder->payment_reference ?? '-' }}</p>
        <p><strong>Amount:</strong> {{ $paymentOrder->amount }} {{ $paymentOrder->currency }}</p>
        <p><strong>Status:</strong> {{ ucfirst($paymentOrder->status) }}</p>
        <p><strong>Merchant:</strong> {{ $paymentOrder->merchant->business_name ?? '-' }}</p>
        <p><strong>Customer:</strong> {{ $paymentOrder->customer_name }}</p>
        <p><strong>Email:</strong> {{ $paymentOrder->customer_email }}</p>
        <p><strong>Phone:</strong> {{ $paymentOrder->customer_phone }}</p>
        <p><strong>Callback URL:</strong> {{ $paymentOrder->callback_url }}</p>
    </div>
</div>

<h4 class="mt-4">Webhook Logs</h4>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Event</th>
            <th>Status</th>
            <th>Attempts</th>
            <th>Response</th>
        </tr>
    </thead>

    <tbody>
        @foreach($paymentOrder->webhookEvents as $event)
            <tr>
                <td>{{ $event->event_type }}</td>
                <td>{{ $event->status }}</td>
                <td>{{ $event->attempts }}</td>
                <td>{{ Str::limit($event->response, 80) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection