@extends('layouts.app')

@section('content')
<div>
    <div class="row col-12 justify-content-center">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
        <addtask></addtask>
        <table-component></table-component>
<!--        <tasks></tasks>-->
<!--        <taskstable></taskstable>-->
<!--                    <choosing-component></choosing-component>-->

<!--        <loading-component></loading-component>-->
    </div>
</div>
@endsection
