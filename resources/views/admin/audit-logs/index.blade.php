@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h2>Audit Logs</h2>
</div>

<form method="GET" class="row mt-4 mb-3">
    <div class="col-md-4">
        <select name="action" class="form-control">
            <option value="">All Actions</option>

            @foreach($actions as $action)
                <option
                    value="{{ $action }}"
                    {{ request('action') === $action ? 'selected' : '' }}
                >
                    {{ str_replace('_', ' ', $action) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">
            Filter
        </button>
    </div>

    <div class="col-md-2">
        <a href="{{ route('admin.audit-logs.index') }}"
           class="btn btn-secondary">
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
                <th>Action</th>
                <th>Entity</th>
                <th>Entity ID</th>
                <th>IP Address</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($auditLogs as $auditLog)
                <tr>
                    <td>{{ $auditLog->id }}</td>

                    <td>
                        {{ $auditLog->user->name ?? 'System/Guest' }}
                    </td>

                    <td>
                        <span class="badge bg-primary">
                            {{ str_replace('_', ' ', $auditLog->action) }}
                        </span>
                    </td>

                    <td>
                        {{ $auditLog->entity_type
                            ? class_basename($auditLog->entity_type)
                            : '-'
                        }}
                    </td>

                    <td>{{ $auditLog->entity_id ?? '-' }}</td>
                    <td>{{ $auditLog->ip_address ?? '-' }}</td>

                    <td>
                        {{ $auditLog->created_at->format('d M Y h:i A') }}
                    </td>

                    <td>
                        <a
                            href="{{ route('admin.audit-logs.show', $auditLog->id) }}"
                            class="btn btn-sm btn-primary"
                        >
                            View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        No audit logs found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $auditLogs->links() }}
@endsection