@extends('admin.layouts.app')

@section('content')
<h2>Merchant Detail</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card mt-4">
    <div class="card-body">
        <p><strong>Business Name:</strong> {{ $merchant->business_name }}</p>
        <p><strong>Business Email:</strong> {{ $merchant->business_email }}</p>
        <p><strong>Business Phone:</strong> {{ $merchant->business_phone }}</p>
        <p><strong>Business Type:</strong> {{ $merchant->business_type }}</p>
        <p><strong>Owner:</strong> {{ $merchant->user->name }}</p>
        <p><strong>Status:</strong> {{ ucfirst($merchant->status) }}</p>

        <hr>

        <form method="POST" action="{{ route('admin.merchants.update-status', $merchant->id) }}">
            @csrf

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Remarks</label>
                <textarea name="remarks" class="form-control">{{ $merchant->remarks }}</textarea>
            </div>

            <button class="btn btn-success">Update Status</button>
        </form>
    </div>
</div>
@endsection