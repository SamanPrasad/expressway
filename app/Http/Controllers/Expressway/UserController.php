<?php

namespace App\Http\Controllers\Expressway;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userRepository;

    private $roles = ['Admin', 'Manager', 'Data Entry', 'Owner', 'Driver', 'Conductor'];

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    //get users view
    public function index(){
        $users = $this->userRepository->all();
        return view('functions.users')->with('users', $users)->with('roles', $this->roles);
    }

    //Add user
    public function create(Request $request){
        $user = $this->userRepository->add($request);
        if(is_null($user)){
            return 'error';
        }

        return redirect()->back()->with('message', 'User added successfully !');
    }

    //get signle user details
    public function singleUser(Request $request){
        $user = $this->userRepository->user($request->input('id'));
        return [
            'user'=>$user,
            'roles'=>$this->roles
        ];
    }

    //Update user
    public function update(Request $request){
        return $this->userRepository->update($request);
    }

    //delete user
    public function destroy($id){
        $user = $this->userRepository->user($id);
        if(is_null($user)){
            return "error";
        }

        $result = $user->delete();

        if($result){
            return 'success';
        }

        return 'error';
    }
}
