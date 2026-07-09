@extends('admin.layouts.app')

@section('content')
    <h2>Dashboard</h2>

    <div class="row mt-4">

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Total Users</h6>
                   <h3>{{ $stats['total_users'] }}</h3>
                   
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Total Merchants</h6>
                    <h3>{{ $stats['total_merchants'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Total Payments</h6>
                    <h3>{{ $stats['total_payments'] }}</h3>
                </div>
            </div>
        </div>


                <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Total Webhooks</h6>
                    <h3>{{ $stats['total_webhooks'] }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection