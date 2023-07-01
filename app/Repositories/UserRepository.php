<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserRepository{

    //get all users
    public function all(){
        return $users = User::paginate(5);
    }

    //Create user
    public function add(Request $request){
        $this->regularValidation($request);
        $details = [
            'first_name'=>$request->fname,
            'last_name'=>$request->lname,
            'role'=>$request->role,
            'email'=>$request->email,
            'password'=>$request->password,
        ];

        return User::create($details);
    }

    //Basic validation of inputs
    private function validate(Request $request){
        $rules = [
            'role'=>'required',
            'fname'=>'required|alpha|max:255',
            'lname'=>'required|alpha|max:255',
            'email'=>'required_if:role,==,Manager|required_if:role,==,Admin|required_if:role,==,Data Entry|required_if:role,==,Owner|email|unique:users,email',
            'password'=>'required_if:role,==,Manager|required_if:role,==,Admin|required_if:role,==,Data Entry|required_if:role,==,Owner|min:5',
        ];

        $messages = [
            'role.required'=> 'Role field cannot be empty!',
            'fname.required'=> 'First Name field cannot be empty!',
            'fname.alpha'=> 'First Name field must only contain letters!',
            'fname.max'=> 'First Name field cannot contain more than 255 letters!',
            'lname.required'=> 'Last Name field cannot be empty!',
            'lname.alpha'=> 'Last Name field must only contain letters!',
            'lname.max'=> 'Last Name field cannot contain more than 255 letters!',
            'email.required_if'=> 'Email field is required when Role is not Driver or Conductor!',
            'email.email' => 'Please enter a valid email address!',
            'email.unique' => 'Entered email is already in use!',
            'password.required_if'=> 'Email field is required when Role is not Driver or Conductor!',
            'password.min' => 'Password must contain more than 5 characters!',
        ];

        return Validator::make($request->all(), $rules, $messages);
        // $validation->validate();

        // if($validation->fails()){
        //     dd($validation->messages());
        // }
    }

    //Regular validation
    private function regularValidation(Request $request){
        $validator = $this->validate($request);
        $validator->validate();
    }

    //AJAX validation
    private function ajaxVlidation(Request $request){
        return $this->validate($request)->messages();
    }

    //get single user
    public function user($id){
        return User::find($id);
    }
}