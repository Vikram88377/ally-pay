@extends('merchant.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h2>Webhook Settings</h2>
</div>

@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger mt-3">
        {{ $errors->first() }}
    </div>
@endif

<div class="card mt-4 shadow-sm">
    <div class="card-body">

        <form method="POST"
              action="{{ route('merchant.webhook-settings.store') }}">

            @csrf

            <div class="mb-3">
                <label class="form-label">
                    Callback URL
                </label>

                <input
                    type="url"
                    name="callback_url"
                    value="{{ old('callback_url', $setting?->callback_url) }}"
                    class="form-control"
                    placeholder="https://merchant-site.com/webhooks/ally-pay"
                    required
                >

                <small class="text-muted">
                    Payment success or failure events will be sent to this URL.
                </small>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Webhook Secret
                </label>

                <input
                    type="text"
                    value="{{ $setting?->secret_key ?? 'Secret will be generated after first save' }}"
                    class="form-control"
                    readonly
                >

                <small class="text-muted">
                    Use this secret to verify webhook signatures on your server.
                </small>
            </div>

            <div class="form-check mb-3">
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    class="form-check-input"
                    id="is_active"
                    {{ old('is_active', $setting?->is_active) ? 'checked' : '' }}
                >

                <label class="form-check-label" for="is_active">
                    Enable webhook
                </label>
            </div>

            <button type="submit" class="btn btn-primary">
                Save Settings
            </button>

        </form>
    </div>
</div>
@endsection