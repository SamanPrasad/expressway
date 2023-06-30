@extends('layouts.app')

@section('content')
    <div class="container test">
        <h1 class="text-center express-font">Role - {{ucfirst(Auth::user()->role)}}</h1>
        <div class="d-flex flex-column justify-content-start align-items-center">
            @if(in_array(Auth::user()->role, ['owner', 'admin']))
                <a href="/users"><button type="button" class="btn btn-info expressway-btn my-2">Manage Users</button></a>
            @endif
            @if(in_array(Auth::user()->role, ['owner', 'manager']))
                <a href="/reports"><button type="button" class="btn btn-info expressway-btn my-2">View Reports</button></a>
            @endif               
            @if(in_array(Auth::user()->role, ['owner', 'data']))
                <a href="/buses"><button type="button" class="btn btn-info expressway-btn my-2">Manage Buses</button></a>
            @endif
            @if(in_array(Auth::user()->role, ['owner', 'data']))
                <a href="/routes"><button type="button" class="btn btn-info expressway-btn my-2">Manage Routes</button></a>
            @endif
            @if(in_array(Auth::user()->role, ['owner', 'data']))
                <a href="/trips"><button type="button" class="btn btn-info expressway-btn my-2">Schedule Buses</button></a>
            @endif
        </div>
    </div>
@endsection
