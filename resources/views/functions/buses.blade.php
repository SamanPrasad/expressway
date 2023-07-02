@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Manage Buses</h1>
        @if(auth()->user()->role != 'Manager')
            <!-- Bus registration form -->
            <div class="d-flex justify-content-center pt-3">
                <form action="/bus" method="post">
                    @csrf
                    <table>
                        <h2 class="text-center">Add Bus</h2>
                        <tr>
                            <td class="px-3">
                                <label for="">Registration Number</label>
                            </td>
                            <td class="px-3">
                                <input type="text" name="registration-number" id="registration-number" value="{{old('registration-number')}}">
                            </td>
                        </tr>
                        @error('registration-number')
                            <tr>
                                <td colspan="2" class="text-center expressway-error py-2">
                                    {{$message}}
                                </td>
                            </tr>
                        @enderror
                        <tr>
                            <td class="px-3">
                                <label for="">Type</label>
                            </td>
                            <td class="px-3">
                                <input type="text" name="type" id="type" value="{{old('type')}}">
                            </td>
                        </tr>
                        @error('type')
                            <tr>
                                <td colspan="2" class="text-center expressway-error py-2">
                                    {{$message}}
                                </td>
                            </tr>
                        @enderror
                        <tr>
                            <td class="px-3">
                                <label for="">Capacity</label>
                            </td>
                            <td class="px-3">
                                <input type="text" name="capacity" id="capacity" value="{{old('capacity')}}">
                            </td>
                        </tr>
                        @error('capacity')
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

        <!-- Buses List -->
        <div class="row justify-content-center">
            <div class="col-sm-9">
                <table>
                    <thead>
                        <tr>
                            <td>Registration Number</td>
                            <td>Type</td>
                            <td>Capacity</td>
                            @if(auth()->user()->role != 'Manager')
                                <td class="actions">Actions</td>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($buses as $bus)
                            <tr>
                                <td>{{$bus->registration_number}}</td>
                                <td>{{$bus->type}}</td>
                                <td>{{$bus->capacity}}</td>
                                @if(auth()->user()->role != 'Manager')
                                    <td>
                                        <button data-id="{{$bus->id}}" type="button" class="btn btn-primary expressway-btn-actions edit">Edit</button>
                                        <button data-id="{{$bus->id}}" type="button" class="btn btn-warning expressway-btn-actions delete">Delete</button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{$buses->links()}}
                </div>            
            </div>
        </div>

        @if(auth()->user()->role != 'Manager')
            <!-- Button to trigger edit modal -->
            <button id="buses-edit-modal-trigger" type="button" data-bs-toggle="modal" data-bs-target="#buses-edit-modal" hidden></button>
            
            <!-- Edit Modal -->
            <div class="modal fade" id="buses-edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content d-flex justify-content-center">
                        <div class="d-flex flex-column justify-content-center align-items-center py-4">
                            <svg data-bs-toggle="modal" data-bs-target="#edit-modal" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                            <div>       
                                <input type="text" id="update-bus-id" hidden>                     
                                <table>
                                    <h2 class="text-center">Update Bus</h2>
                                    <tr>
                                        <td class="px-3">
                                            <label for="">Registration Nuber</label>
                                        </td>
                                        <td class="px-3">
                                            <input type="text" id="update-registration-number">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="error text-center expressway-hide expressway-error py-2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-3">
                                            <label for="">Type</label>
                                        </td>
                                        <td class="px-3">
                                            <input type="text" id="update-type">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="error text-center expressway-hide expressway-error py-2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-3">
                                            <label for="">Capacity</label>
                                        </td>
                                        <td class="px-3">
                                            <input type="text" id="update-capacity">
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
            <button id="message-modal-trigger" class="message-modal-trigger" type="button" data-bs-toggle="modal" data-bs-target="#message-modal" hidden></button>

            <!-- Message Modal -->
            <div class="modal fade message-modal" id="message-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        @vite(['resources/js/buses.js'])
    @endsection
@endif