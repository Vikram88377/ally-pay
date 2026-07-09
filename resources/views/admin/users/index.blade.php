@extends('admin.layouts.app')

@section('content')
<h2>Users</h2>

<table class="table table-bordered mt-4">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    {{ $user->roles->pluck('name')->join(', ') }}
                </td>
                <td>
                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-primary">
                        View
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }}
@endsection