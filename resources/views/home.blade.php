@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}  
                    <div class="col-4 col-md-4 col-sm-12 mb-3 mt-4">
                    <a class="btn btn-sm btn-primary btn-block p-2" href=" {{ route('event.view') }}">View Event</a>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
