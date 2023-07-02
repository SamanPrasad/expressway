<?php

namespace App\Repositories\Bus;

use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusRepository implements BusRepositoryInterface{

    //get all buses
    public function all(){
        return Bus::paginate(5);
    }

    //validate input
    private function validate(Request $request){
        $rules = [
            'registration-number'=> 'required|unique:buses,registration_number,'.$request->input('id').'|regex:/^[a-zA-Z0-9]+$/',
            'type'=>'required|alpha',
            'capacity'=>'required|integer'
        ];

        $messages = [
            'registration-number.required'=> 'Registration Number cannot be empty!',
            'registration-number.unique'=> 'Entered number is already in use!',
            'registration-number.regex'=> 'Entered a valid Registration Number (numbers and letters only)!',
            'type.required'=>'Type cannot be empty!',
            'type.alpha'=>'Type can contain only letters',
            'capacity.required'=>'Capacity cannot be empty',
            'capacity.integer'=>'Capacity can only contain integer values!'
        ];

        return Validator::make($request->all(),$rules, $messages);
    }

    //Regular validation
    private function regularValidation(Request $request){
        $validator = $this->validate($request);
        $validator->validate();
    }

    //AJAX validation
    private function ajaxValidation(Request $request){
        return $this->validate($request);
    }

    //Add new bus
    public function add(Request $request){
        $this->regularValidation($request);

        $details = [
            'registration_number'=>strtoupper($request->input('registration-number')),
            'type'=>strtolower($request->input('type')),
            'capacity'=>$request->input('capacity')
        ];

        return Bus::create($details);
    }

    //Update bus
    public function update(Request $request){
        $bus = $this->singleBus($request->id);
        if(is_null($bus)){
            return 'error';
        }

        $validator = $this->ajaxValidation($request);

        if($validator->messages()->first('registration-number') || $validator->messages()->first('type') || $validator->messages()->first('capacity')){
            return $validator->messages();
        }

        $bus->registration_number = strtoupper($request->input('registration-number'));
        $bus->type = strtolower($request->input('type'));
        $bus->capacity = $request->input('capacity');
        $result = $bus->save();

        if($result){
            return 'success';
        }

        return 'error';
    }

    //Get single bus based on id
    public function singleBus($id){
        return Bus::find($id);
    }
}