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
                    <div class="container-fluid">&nbsp;</div>
                    <form>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Stock short code">
                        <button class="btn btn-success" type="submit">Get Price</button>
                    </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
