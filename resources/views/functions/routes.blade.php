@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Manage Routes</h1>
        @if(auth()->user()->role === 'Owner' || auth()->user()->role === 'Admin')
            <!-- Routes registration form -->
            <div class="d-flex justify-content-center pt-3">
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
                                <input type="text" name="email" id="email" value="{{old('email')}}" {{old('role')==='Conductor' || old('role') === 'Driver'?'disabled':''}}>
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
    </div>
@endsection