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
                    <div class="input-group mb-3">
                        <input type="text" id="txtStock" class="form-control" placeholder="Stock short code">
                        <button class="btn btn-success" onclick="getStockData()">Get Price</button>
                    </div>         
                    <div id="demo"></div>           
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function getStockData()
    {
        var stock = document.getElementById('txtStock').value;
        console.log('Stock : '+stock);
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById("demo").innerHTML =
            this.responseText;
        }
        xhttp.open("GET", 'auth/stockdata/' + stock);
        xhttp.send();
    }
</script>
@endsection
