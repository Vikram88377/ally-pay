@extends('admin.layouts.app')

@section('content')
<h2>Webhook Detail</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card mt-4">
    <div class="card-body">
        <p><strong>Event:</strong> {{ $webhookEvent->event_type }}</p>
        <p><strong>Status:</strong> {{ ucfirst($webhookEvent->status) }}</p>
        <p><strong>Attempts:</strong> {{ $webhookEvent->attempts }}</p>
        <p><strong>Callback URL:</strong> {{ $webhookEvent->callback_url }}</p>
        <p><strong>Response:</strong></p>
        <pre>{{ $webhookEvent->response }}</pre>

        <hr>

        <p><strong>Payload:</strong></p>
        <pre>{{ json_encode($webhookEvent->payload, JSON_PRETTY_PRINT) }}</pre>

        @if($webhookEvent->status === 'failed')
            <form method="POST" action="{{ route('admin.webhooks.retry', $webhookEvent->id) }}">
                @csrf
                <button class="btn btn-warning">Retry Webhook</button>
            </form>
        @endif
    </div>
</div>
@endsection