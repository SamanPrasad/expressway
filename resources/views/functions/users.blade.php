@extends('layouts.app')

@section('content')
    <div class="container pb-5">
        <h1 class="text-center">Manage Users</h1>
        @if(auth()->user()->role === 'Owner' || auth()->user()->role === 'Admin')
            <!-- User registration form -->
            <div class="d-flex justify-content-center pt-4">
                <form action="/user" method="post">
                    @csrf
                    <table>
                        <h2 class="text-center">Add User</h2>
                        <tr>
                            <td class="px-3">
                                <label for="">Role</label>
                            </td>
                            <td class="px-3">
                                <select name="role" id="role">
                                    @foreach($roles as $role)
                                        <option value="{{$role}}" {{$role === old('role')?'selected':''}}>{{$role}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @error('role')
                            <tr>
                                <td colspan="2" class="text-center expressway-error py-2">
                                    {{$message}}
                                </td>
                            </tr>
                        @enderror
                        <tr>
                            <td class="px-3">
                                <label for="">First Name</label>
                            </td>
                            <td class="px-3">
                                <input type="text" name="fname" id="fname" value="{{old('fname')}}">
                            </td>
                        </tr>
                        @error('fname')
                            <tr>
                                <td colspan="2" class="text-center expressway-error py-2">
                                    {{$message}}
                                </td>
                            </tr>
                        @enderror
                        <tr>
                            <td class="px-3">
                                <label for="">Last Name</label>
                            </td>
                            <td class="px-3">
                                <input type="text" name="lname" id="lname" value="{{old('lname')}}">
                            </td>
                        </tr>
                        @error('lname')
                            <tr>
                                <td colspan="2" class="text-center expressway-error py-2">
                                    {{$message}}
                                </td>
                            </tr>
                        @enderror
                        <tr>
                            <td class="px-3">
                                <label for="">E-mail</label>
                            </td>
                            <td class="px-3">
                                <input type="text" name="email" id="email" value="{{old('email')}}">
                            </td>
                        </tr>
                        @error('email')
                            <tr>
                                <td colspan="2" class="text-center expressway-error py-2">
                                    {{$message}}
                                </td>
                            </tr>
                        @enderror
                        <tr>
                            <td class="px-3">
                                <label for="">Password</label>
                            </td>
                            <td class="px-3">
                                <input type="password" name="password" id="password" value="{{old('password')}}" {{old('role')==='Conductor' || old('role') === 'Driver'?'disabled':''}}>
                            </td>
                        </tr>
                        @error('password')
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
        <!-- Users List -->
        <div class="mt-5">
            <h2 class="text-center">Current Users List</h2>
            <table class="mt-5">
                <thead>
                    <tr>
                        <td>First Name</td>
                        <td>Last Name</td>
                        <td>Email</td>
                        <td>Role</td>
                        @if(auth()->user()->role === 'Owner' || auth()->user()->role === 'Admin')
                            <td class="actions">Actions</td>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->first_name}}</td>
                            <td>{{$user->last_name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->role}}</td>
                            @if(auth()->user()->role === 'Owner' || auth()->user()->role === 'Admin')
                                @if(!($user->role === 'Owner' && auth()->user()->role === 'Admin'))
                                    <td>
                                        <button data-id="{{$user->user_id}}" type="button" class="btn btn-primary expressway-btn-actions edit">Edit</button>
                                        <button data-id="{{$user->user_id}}" type="button" class="btn btn-warning expressway-btn-actions delete">Delete</button>
                                    </td>
                                @endif
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{$users->links()}}
            </div>            
        </div>

        @if(auth()->user()->role === 'Owner' || auth()->user()->role === 'Admin')
            <!-- Button to trigger edit modal -->
            <button id="edit-modal-trigger" type="button" data-bs-toggle="modal" data-bs-target="#edit-modal" hidden></button>
            
            <!-- Edit Modal -->
            <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content d-flex justify-content-center">
                        <div class="d-flex flex-column justify-content-center align-items-center py-4">
                            <svg data-bs-toggle="modal" data-bs-target="#edit-modal" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                            <div>       
                                <input type="text" id="update-user-id" hidden>                     
                                <table>
                                    <h2 class="text-center">Update User</h2>
                                    <tr>
                                        <td class="px-3">
                                            <label for="">First Name</label>
                                        </td>
                                        <td class="px-3">
                                            <input type="text" id="update-fname">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="error text-center expressway-hide expressway-error py-2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-3">
                                            <label for="">Last Name</label>
                                        </td>
                                        <td class="px-3">
                                            <input type="text" id="update-lname">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="error text-center expressway-hide expressway-error py-2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-3">
                                            <label for="">E-mail</label>
                                        </td>
                                        <td class="px-3">
                                            <input type="text" id="update-email">
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
            <button class="message-modal-trigger" type="button" data-bs-toggle="modal" data-bs-target="#message-modal" hidden></button>

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

@if(auth()->user()->role === 'Owner' || auth()->user()->role === 'Admin')
    @section('script')
        @vite(['resources/js/users.js'])
    @endsection
@endif