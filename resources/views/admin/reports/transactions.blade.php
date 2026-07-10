@extends('admin.layouts.app')

@section('content')
<a
    href="{{ route('admin.reports.payments') }}"
    class="btn btn-outline-primary"
>
    Payment Report
</a>
<div class="d-flex justify-content-between align-items-center">
    <h2>Wallet Transaction Report</h2>

    <a
        href="{{ route('admin.reports.transactions.export', request()->query()) }}"
        class="btn btn-success"
    >
        Export CSV
    </a>
</div>

<form method="GET" class="row mt-4 mb-3">
    <div class="col-md-3">
        <label class="form-label">Transaction Type</label>

        <select name="type" class="form-control">
            <option value="">All Types</option>

            <option value="credit" {{ request('type') === 'credit' ? 'selected' : '' }}>
                Credit
            </option>

            <option value="debit" {{ request('type') === 'debit' ? 'selected' : '' }}>
                Debit
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
            href="{{ route('admin.reports.transactions') }}"
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
                <th>ID</th>
                <th>User</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Balance After</th>
                <th>Reference</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>

                    <td>
                        {{ $transaction->wallet->user->name ?? '-' }}
                    </td>

                    <td>
                        {{ ucfirst($transaction->type) }}
                    </td>

                    <td>
                        ₹{{ number_format($transaction->amount, 2) }}
                    </td>

                    <td>
                        ₹{{ number_format($transaction->balance_after, 2) }}
                    </td>

                    <td>
                        {{ $transaction->reference_id ?? '-' }}
                    </td>

                    <td>
                        {{ ucfirst($transaction->status) }}
                    </td>

                    <td>
                        {{ $transaction->created_at->format('d M Y h:i A') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        No transaction records found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $transactions->links() }}
@endsection