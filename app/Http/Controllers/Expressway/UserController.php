<?php

namespace App\Http\Controllers\Expressway;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $users = $this->userRepository->allWithPagination();
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
        return $this->userRepository->singleUser($request->input('id'));
    }

    //Update user
    public function update(Request $request){
        return $this->userRepository->update($request);
    }

    //delete user
    public function destroy($id){
        if(Auth::check()){
            return $this->userRepository->delete($id);        
        }

        return redirect('/');
    }
}
