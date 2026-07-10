@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h2>Audit Log Detail</h2>

    <a href="{{ route('admin.audit-logs.index') }}"
       class="btn btn-secondary">
        Back
    </a>
</div>

<div class="card mt-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p>
                    <strong>ID:</strong>
                    {{ $auditLog->id }}
                </p>

                <p>
                    <strong>User:</strong>
                    {{ $auditLog->user->name ?? 'System/Guest' }}
                </p>

                <p>
                    <strong>User Email:</strong>
                    {{ $auditLog->user->email ?? '-' }}
                </p>

                <p>
                    <strong>Action:</strong>
                    {{ str_replace('_', ' ', $auditLog->action) }}
                </p>
            </div>

            <div class="col-md-6">
                <p>
                    <strong>Entity Type:</strong>
                    {{ $auditLog->entity_type
                        ? class_basename($auditLog->entity_type)
                        : '-'
                    }}
                </p>

                <p>
                    <strong>Entity ID:</strong>
                    {{ $auditLog->entity_id ?? '-' }}
                </p>

                <p>
                    <strong>IP Address:</strong>
                    {{ $auditLog->ip_address ?? '-' }}
                </p>

                <p>
                    <strong>Created At:</strong>
                    {{ $auditLog->created_at->format('d M Y h:i A') }}
                </p>
            </div>
        </div>

        <hr>

        <h5>Old Values</h5>

        <pre class="bg-light border rounded p-3">{{ json_encode(
            $auditLog->old_values,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        ) }}</pre>

        <h5 class="mt-4">New Values</h5>

        <pre class="bg-light border rounded p-3">{{ json_encode(
            $auditLog->new_values,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        ) }}</pre>

        <h5 class="mt-4">User Agent</h5>

        <div class="bg-light border rounded p-3">
            {{ $auditLog->user_agent ?? '-' }}
        </div>
    </div>
</div>
@endsection