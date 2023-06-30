@extends('layouts.app')
@section('content')
    <div class="test">
        <h1>Manage Users</h1>
        <form action="/user/add">
            <input type="text">
        </form>
    </div>
@endsection