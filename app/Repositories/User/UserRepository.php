<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserRepository implements UserRepositoryInterface{

    //get all users with pagination
    public function allWithPagination(){
        return $users = User::paginate(5);
    }

    //get all users
    public function all(){
        return User::all();
    }

    //Create user
    public function add(Request $request){
        $this->regularValidation($request);
        $details = [
            'first_name'=>ucfirst($request->fname),
            'last_name'=>ucfirst($request->lname),
            'role'=>$request->role,
            'email'=>strtolower($request->email),
            'password'=>$request->password,
        ];

        return User::create($details);
    }

    //Update user
    public function update(Request $request){
        $user  = $this->singleUser($request->user_id);
        if(is_null($user)){
            return 'error';
        }

        $validator = $this->ajaxVlidation($request);

        if($validator->messages()->first('fname') || $validator->messages()->first('lname') || $validator->messages()->first('email')){
            return $validator->messages();
        }

        $user->first_name = ucfirst($request->fname);
        $user->last_name = ucfirst($request->lname);
        $user->email = strtolower($request->email);
        $result = $user->save();

        if($result){
            return 'success';
        }

        return 'error';
    }

    //Basic validation of inputs
    private function validate(Request $request){
        $rules = [
            'role'=>'required',
            'fname'=>'required|alpha|max:255',
            'lname'=>'required|alpha|max:255',
            'email'=>'required|email:filter|unique:users,email,'.$request->user_id.',user_id',
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
            'email.required'=> 'Email field cannot be empty!',
            'email.email' => 'Please enter a valid email address!',
            'email.unique' => 'Entered email is already in use!',
            'password.required_if'=> 'Password field is required when Role is not Driver or Conductor!',
            'password.min' => 'Password must contain more than 5 characters!',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    //Regular validation
    private function regularValidation(Request $request){
        $validator = $this->validate($request);
        $validator->validate();
    }

    //AJAX validation
    private function ajaxVlidation(Request $request){
        return $this->validate($request);
    }

    //get single user
    public function singleUser($id){
        return User::find($id);
    }

    //Delete useer
    public function delete($id){
        $user = User::find($id);
        if(is_null($user)){
            return "error";
        }

        $user->driverTrips()->delete();
        $user->conductorTrips()->delete();

        $result = $user->delete();

        if($result){
            return 'success';
        }

        return 'error';
    }

    //User based on the role
    public function userWithRole($role){
        return User::where('role',$role)->get();
    }
}