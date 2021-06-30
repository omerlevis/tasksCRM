@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
        <addtasks></addtasks>
<!--                    <choosing-component></choosing-component>-->
<!--                    <table-component></table-component>-->
<!--        <loading-component></loading-component>-->
    </div>
</div>
@endsection
