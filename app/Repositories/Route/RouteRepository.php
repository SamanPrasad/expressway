<?php

namespace App\Repositories\Route;

use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RouteRepository implements RouteRepositoryInterface{

    public function allWithPagination(){
        return Route::paginate(5);
    }

    public function all(){
        return Route::all();
    }

    public function add(Request $request){
        $this->regularValidation($request);

        $details = [
            'route_number'=>$request->input('route-number'),
            'from'=>$request->input('from'),
            'to'=>$request->input('to')
        ];

        return Route::create($details);
    }

    public function update(Request $request){
        $route = $this->singleRoute($request->input('id'));
        if(is_null($route)){
            return 'error';
        }

        $validator = $this->ajaxValidation($request);

        if($validator->fails()){
            return $validator->messages();
        }

        $route->route_number = $request->input('route-number');
        $route->from = $request->input('from');
        $route->to = $request->input('to');
        $result = $route->save();

        if($result){
            return 'success';
        }

        return 'error';
    }

    private function validate(Request $request){
        $rules = [
            'route-number'=>'required|integer|unique:routes,route_number,'.$request->input('id'),
            'from'=>'required|alpha|min:2',
            'to'=>'required|alpha|min:2'
        ];

        $messages = [
            'route-number.required'=>'Route Number cannot be empty!',
            'route-number.integer'=>'Route Number can contain only letters!',
            'route-number.unique'=>'Entered Route Number is already in use!',
            'from.required'=>'From field cannot be empty!',
            'from.alpha'=>'From field can contain only letters!',
            'from.min'=>'From field should contain more than 2 letters!',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    private function regularValidation(Request $request){
        $validator = $this->validate($request);
        $validator->validate();
    }

    private function ajaxValidation(Request $request){
        return $this->validate($request);
    }

    public function singleRoute($id){
        return Route::find($id);
    }

    //Delete user
    public function delete($id){
        $route = $this->singleRoute($id);
        if(is_null($route)){
            return 'error';
        }

        $route->trips()->delete();

        $result = $route->delete();
        if($result){
            return 'success';
        }

        return 'error';
    }
}