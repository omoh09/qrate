@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    Processing.....
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        (function(){
            if(window.opener){
                window.location.href = {{!! config('app.client_url') ."/home/paymentstatus" !!}}
            }
        })();
    </script>
@endpush
