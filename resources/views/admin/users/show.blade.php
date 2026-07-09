@extends('admin.layouts.app')

@section('content')
<h2>User Detail</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card mt-4">
    <div class="card-body">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Current Role:</strong> {{ $user->roles->pluck('name')->join(', ') }}</p>

        <form method="POST" action="{{ route('admin.users.assign-role', $user->id) }}">
            @csrf

            <div class="mb-3">
                <label>Assign Role</label>
                <select name="role" class="form-control">
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-success">Assign Role</button>
        </form>
    </div>
</div>
@endsection