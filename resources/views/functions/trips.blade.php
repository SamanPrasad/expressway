@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Schedule Buses</h1>
        @if(auth()->user()->role === 'Owner' || auth()->user()->role === 'Data Entry')
            <!-- Trip Schedule form -->
            <div class="d-flex justify-content-center pt-4">
                <form action="/trip" method="post">
                    @csrf
                    <table>
                        <h2 class="text-center">Schedule Bus</h2>
                        <tr>
                            <td class="px-3">
                                <label for="">Bus ID</label>
                            </td>
                            <td class="px-3">
                                <select name="bus-id" id="bus-id">
                                    <option value="">Select Bus ID</option>
                                    @foreach($buses as $bus)
                                        <option value="{{$bus->registration_number}}" {{$bus->registration_number === old('bus-id')?'selected':''}}>{{$bus->registration_number}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @error('bus-id')
                            <tr>
                                <td colspan="2" class="text-center expressway-error py-2">
                                    {{$message}}
                                </td>
                            </tr>
                        @enderror
                        <tr>
                            <td class="px-3">
                                <label for="">Start At</label>
                            </td>
                            <td class="px-3">
                                <input type="datetime-local" name="start-at" id="start-at" value="{{old('start-at')}}">
                            </td>
                        </tr>
                        @error('start-at')
                            <tr>
                                <td colspan="2" class="text-center expressway-error py-2">
                                    {{$message}}
                                </td>
                            </tr>
                        @enderror
                        <tr>
                            <td class="px-3">
                                <label for="">Start From</label>
                            </td>
                            <td class="px-3">
                                <input type="text" name="start-from" id="start-from" value="{{old('start-from')}}">
                            </td>
                        </tr>
                        @error('start-from')
                            <tr>
                                <td colspan="2" class="text-center expressway-error py-2">
                                    {{$message}}
                                </td>
                            </tr>
                        @enderror
                        <tr>
                            <td class="px-3">
                                <label for="">Destination</label>
                            </td>
                            <td class="px-3">
                                <input type="text" name="destination" id="destination" value="{{old('destination')}}">
                            </td>
                        </tr>
                        @error('destination')
                            <tr>
                                <td colspan="2" class="text-center expressway-error py-2">
                                    {{$message}}
                                </td>
                            </tr>
                        @enderror
                        <tr>
                            <td class="px-3">
                                <label for="">Route Number</label>
                            </td>
                            <td class="px-3">
                                <select name="route-number" id="route-number">
                                    <option value="">Select Route Number</option>
                                    @foreach($routes as $route)
                                        <option value="{{$route->route_number}}" {{$route->route_number == old('route-number') ? 'selected':''}}>{{$route->route_number}}</option>
                                    @endforeach
                                </select>
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
                                <label for="">Driver ID</label>
                            </td>
                            <td class="px-3">
                                <select name="driver-id" id="driver-id">
                                    <option value="">Select Driver ID</option>
                                    @foreach($drivers as $driver)
                                        <option value="{{$driver->user_id}}" {{$driver->user_id == old('driver-id')?'selected':''}}>{{$driver->user_id}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @error('driver-id')
                            <tr>
                                <td colspan="2" class="text-center expressway-error py-2">
                                    {{$message}}
                                </td>
                            </tr>
                        @enderror
                        <tr>
                            <td class="px-3">
                                <label for="">Conductor ID</label>
                            </td>
                            <td class="px-3">
                                <select name="conductor-id" id="conductor-id">
                                    <option value="">Select Conductor ID</option>
                                    @foreach($conductors as $conductor)
                                        <option value="{{$conductor->user_id}}" {{$conductor->user_id == old('conductor-id')?'selected':''}}>{{$conductor->user_id}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @error('conductor-id')
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

        <!-- Schedules List-->
        <div>
            <h2 class="text-center">Scheduled Buses List</h2>
            <table class="mt-5">
                <thead>
                    <tr>
                        <td>Trip ID</td>
                        <td>Start At</td>
                        <td>Start From</td>
                        <td>Destination</td>
                        <td>Route ID</td>
                        <td>Bus ID</td>
                        <td>Driver ID</td>
                        <td>Driver Name</td>
                        <td>Conductor ID</td>
                        <td>Conductor Name</td>
                        @if(auth()->user()->role === 'Owner' || auth()->user()->role === 'Data Entry')
                            <td class="actions">Actions</td>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($trips as $trip)
                        <tr>
                            <td>{{$trip->trip_id}}</td>
                            <td>{{$trip->start_at}}</td>
                            <td>{{$trip->start_from}}</td>
                            <td>{{$trip->destination}}</td>
                            <td>{{$trip->route_number}}</td>
                            <td>{{$trip->bus_number}}</td>
                            <td>{{$trip->driver_id}}</td>
                            <td>{{$trip->driver->first_name}} {{$trip->driver->last_name}}</td>
                            <td>{{$trip->conductor_id}}</td>
                            <td>{{$trip->conductor->first_name}} {{$trip->driver->last_name}}</td>
                            @if(auth()->user()->role === 'Owner' || auth()->user()->role === 'Data Entry')
                                <td>
                                    <button data-id="{{$trip->trip_id}}" type="button" class="btn btn-primary expressway-btn-actions edit">Edit</button>
                                    <button data-id="{{$trip->trip_id}}" type="button" class="btn btn-warning expressway-btn-actions delete">Delete</button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{$trips->links()}}
            </div>  
        </div>

        @if(auth()->user()->role === 'Owner' || auth()->user()->role === 'Data Entry')
            <!-- Button to trigger edit modal -->
            <button id="trips-edit-modal-trigger" type="button" data-bs-toggle="modal" data-bs-target="#trips-edit-modal" hidden></button>
            
            <!-- Edit Modal -->
            <div class="modal fade" id="trips-edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content d-flex justify-content-center">
                        <div class="d-flex flex-column justify-content-center align-items-center py-4">
                            <svg data-bs-toggle="modal" data-bs-target="#edit-modal" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                            <div>       
                                <input type="text" id="update-trip-id" hidden>                     
                                <table>
                                    <h2 class="text-center">Update Trip</h2>
                                    <tr>
                                        <td class="px-3">
                                            <label for="">Registration Number</label>
                                        </td>
                                        <td class="px-3">
                                            <select name="" id="update-bus-id"></select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="error text-center expressway-hide expressway-error py-2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-3">
                                            <label for="">Start At</label>
                                        </td>
                                        <td class="px-3">
                                            <input type="datetime-local" id="update-start-at">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="error text-center expressway-hide expressway-error py-2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-3">
                                            <label for="">Start From</label>
                                        </td>
                                        <td class="px-3">
                                            <input type="text" id="update-start-from">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="error text-center expressway-hide expressway-error py-2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-3">
                                            <label for="">Destination</label>
                                        </td>
                                        <td class="px-3">
                                            <input type="text" id="update-destination">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="error text-center expressway-hide expressway-error py-2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-3">
                                            <label for="">Route Number</label>
                                        </td>
                                        <td class="px-3">
                                            <select name="" id="update-route-number"></select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="error text-center expressway-hide expressway-error py-2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-3">
                                            <label for="">Driver ID</label>
                                        </td>
                                        <td class="px-3">
                                            <select name="" id="update-driver-id"></select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="error text-center expressway-hide expressway-error py-2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-3">
                                            <label for="">Conductor ID</label>
                                        </td>
                                        <td class="px-3">
                                            <select name="" id="update-conductor-id"></select>
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
            <button class="message-modal-trigger" type="button" data-bs-toggle="modal" data-bs-target="#trip-message-modal" hidden></button>

            <!-- Message Modal -->
            <div class="modal fade message-modal" id="trip-message-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

@if(auth()->user()->role === 'Owner' || auth()->user()->role === 'Data Entry')
    @section('script')
        @vite(['resources/js/trips.js'])
    @endsection
@endif