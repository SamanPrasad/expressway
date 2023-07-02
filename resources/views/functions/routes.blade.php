@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Manage Routes</h1>
        @if(auth()->user()->role === 'Owner' || auth()->user()->role === 'Data Entry')
            <!-- Routes registration form -->
            <div class="d-flex justify-content-center pt-4">
                <form action="/bus-route" method="post">
                    @csrf
                    <table>
                        <h2 class="text-center">Add Bus Route</h2>
                        <tr>
                            <td class="px-3">
                                <label for="">Route Number</label>
                            </td>
                            <td class="px-3">
                                <input type="text" name="route-number" id="route-number" value="{{old('route-number')}}">
                            </td>
                        </tr>
                        @error('route-number')
                            <tr>
                                <td colspan="2" class="text-center expressway-error py-2">
                                    {{$message}}
                                </td>
                            </tr>
                        @enderror
                        <tr>
                            <td class="px-3">
                                <label for="">From</label>
                            </td>
                            <td class="px-3">
                                <input type="text" name="from" id="from" value="{{old('from')}}">
                            </td>
                        </tr>
                        @error('from')
                            <tr>
                                <td colspan="2" class="text-center expressway-error py-2">
                                    {{$message}}
                                </td>
                            </tr>
                        @enderror
                        <tr>
                            <td class="px-3">
                                <label for="">To</label>
                            </td>
                            <td class="px-3">
                                <input type="text" name="to" id="to" value="{{old('to')}}">
                            </td>
                        </tr>
                        @error('to')
                            <tr>
                                <td colspan="2" class="text-center expressway-error py-2">
                                    {{$message}}
                                </td>
                            </tr>
                        @enderror
                    </table>
                    <div class="d-flex justify-content-center py-3">
                        <button type="submit" class="btn btn-primary expressway-btn-small">Add</button>
                    </div>
                </form>
            </div>
            <!-- Success Message -->
            @if(session()->has('message'))
                <div>
                    <h2 class="text-center expressway-success">{{session('message')}}</h2>
                </div>
            @endif
            <hr class="my-5">
        @endif
        <!-- Routes List -->
        <div class="mt-5">
            <h2 class="text-center">Current Bus Routes List</h2>
            <table class="mt-5">
                <thead>
                    <tr>
                        <td>Route Number</td>
                        <td>From</td>
                        <td>To</td>
                        @if(auth()->user()->role === 'Owner' || auth()->user()->role === 'Data Entry')
                            <td class="actions">Actions</td>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($routes as $route)
                        <tr>
                            <td>{{$route->route_number}}</td>
                            <td>{{$route->from}}</td>
                            <td>{{$route->to}}</td>
                            @if(auth()->user()->role === 'Owner' || auth()->user()->role === 'Data Entry')
                                <td>
                                    <button data-id="{{$route->id}}" type="button" class="btn btn-primary expressway-btn-actions edit">Edit</button>
                                    <button data-id="{{$route->id}}" type="button" class="btn btn-warning expressway-btn-actions delete">Delete</button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{$routes->links()}}
            </div>            
        </div>

        @if(auth()->user()->role === 'Owner' || auth()->user()->role === 'Data Entry')
            <!-- Button to trigger edit modal -->
            <button id="routes-edit-modal-trigger" type="button" data-bs-toggle="modal" data-bs-target="#routes-edit-modal" hidden></button>
            
            <!-- Edit Modal -->
            <div class="modal fade" id="routes-edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content d-flex justify-content-center">
                        <div class="d-flex flex-column justify-content-center align-items-center py-4">
                            <svg data-bs-toggle="modal" data-bs-target="#edit-modal" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                            <div>       
                                <input type="text" id="update-route-id" hidden>                     
                                <table>
                                    <h2 class="text-center">Update Bus Route</h2>
                                    <tr>
                                        <td class="px-3">
                                            <label for="">Route Nuber</label>
                                        </td>
                                        <td class="px-3">
                                            <input type="text" id="update-route-number">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="error text-center expressway-hide expressway-error py-2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-3">
                                            <label for="">From</label>
                                        </td>
                                        <td class="px-3">
                                            <input type="text" id="update-from">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="error text-center expressway-hide expressway-error py-2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-3">
                                            <label for="">To</label>
                                        </td>
                                        <td class="px-3">
                                            <input type="text" id="update-to">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="error text-center expressway-hide expressway-error py-2">
                                        </td>
                                    </tr>
                                </table>
                                <div class="d-flex justify-content-center py-3">
                                    <button type="button" class="btn btn-primary expressway-btn-small update-button">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button to trigger message modal -->
            <button class="message-modal-trigger" type="button" data-bs-toggle="modal" data-bs-target="#routes-message-modal" hidden></button>

            <!-- Message Modal -->
            <div class="modal fade message-modal" id="routes-message-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content d-flex justify-content-center">
                        <div class="d-flex justify-content-center">
                            <h2 class="modal-title message-content" id="exampleModalLabel"></h2>
                            <button type="button" class="btn ok-btn ms-5" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@if(auth()->user()->role != 'Manager')
    @section('script')
        @vite(['resources/js/bus-routes.js'])
    @endsection
@endif