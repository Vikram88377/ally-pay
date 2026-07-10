@extends('merchant.layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center">
    <h2>API Keys</h2>
</div>


@if(session('success'))

    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>

@endif



@if(session('secret_key'))

    <div class="alert alert-warning mt-3">

        <strong>
            Copy your secret key now.
        </strong>

        <br>

        This key will not be shown again.

        <hr>

        <code>
            {{ session('secret_key') }}
        </code>

    </div>

@endif



<div class="card mt-4 shadow-sm">

    <div class="card-body">


        @if($apiKey)


            <div class="mb-3">

                <label class="form-label">
                    Public Key
                </label>


                <input
                    type="text"
                    value="{{ $apiKey['public_key'] }}"
                    class="form-control"
                    readonly
                >

            </div>



            <div class="mb-3">

                <label class="form-label">
                    Secret Key
                </label>


                <input
                    type="text"
                    value="***********************"
                    class="form-control"
                    readonly
                >


                <small class="text-muted">

                    Secret key is hidden for security reasons.

                </small>

            </div>



            <div class="mb-3">

                <strong>Status:</strong>


                @if($apiKey['is_active'])

                    <span class="badge bg-success">
                        Active
                    </span>

                @else

                    <span class="badge bg-danger">
                        Inactive
                    </span>

                @endif


            </div>



        @else


            <div class="alert alert-info">

                No API key generated yet.

            </div>


        @endif




        <form
            method="POST"
            action="{{ route('merchant.api-keys.regenerate') }}"
            onsubmit="return confirm('Old API key will be disabled. Continue?')"
        >

            @csrf


            <button class="btn btn-primary">

                {{ $apiKey ? 'Regenerate API Key' : 'Generate API Key' }}

            </button>


        </form>


    </div>

</div>


@endsection