@extends('admin.layouts.app')

@section('content')
<h2>Merchants</h2>

<table class="table table-bordered mt-4">
    <thead>
        <tr>
            <th>ID</th>
            <th>Business</th>
            <th>User</th>
            <th>Email</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($merchants as $merchant)
            <tr>
                <td>{{ $merchant->id }}</td>
                <td>{{ $merchant->business_name }}</td>
                <td>{{ $merchant->user->name }}</td>
                <td>{{ $merchant->business_email }}</td>
                <td>
                    <span class="badge bg-secondary">
                        {{ ucfirst($merchant->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.merchants.show', $merchant->id) }}"
                       class="btn btn-sm btn-primary">
                        View
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $merchants->links() }}
@endsection