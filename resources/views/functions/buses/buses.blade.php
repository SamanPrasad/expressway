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
                                <input type="text" name="registration-number" id="registration-number" value="{{old('registrition-number')}}">
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
        <div class="mt-5">
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
                                    <button data-id="{{$bus->registration_number}}" type="button" class="btn btn-primary expressway-btn-actions edit">Edit</button>
                                    <button data-id="{{$bus->registration_number}}" type="button" class="btn btn-warning expressway-btn-actions delete">Delete</button>
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
@endsection