@extends('admin.layouts.app')

@section('content')
<h2>Webhook Logs</h2>

<form method="GET" class="row mt-4 mb-3">
    <div class="col-md-3">
        <select name="status" class="form-control">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
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
            <th>Order ID</th>
            <th>Event</th>
            <th>Status</th>
            <th>Attempts</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($webhooks as $webhook)
            <tr>
                <td>{{ $webhook->id }}</td>
                <td>{{ $webhook->paymentOrder->order_id ?? '-' }}</td>
                <td>{{ $webhook->event_type }}</td>
                <td>{{ ucfirst($webhook->status) }}</td>
                <td>{{ $webhook->attempts }}</td>
                <td>
                    <a href="{{ route('admin.webhooks.show', $webhook->id) }}"
                       class="btn btn-sm btn-primary">
                        View
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $webhooks->links() }}
@endsection