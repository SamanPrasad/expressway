<?php

namespace App\Repositories\Trip;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TripRepository implements TripRepositoryInterface{

    public function allWithPagination(){
        return Trip::with(['bus', 'route', 'driver', 'conductor'])->paginate(4);
    }

    public function add(Request $request){
        $this->regularValidation($request);

        $details = [
            'start_at'=>$request->input('start-at'),
            'start_from'=>$request->input('start-from'),
            'destination'=>$request->input('start-from'),
            'route_number'=>$request->input('route-number'),
            'bus_number'=>$request->input('bus-id'),
            'driver_id'=>$request->input('driver-id'),
            'conductor_id'=>$request->input('conductor-id'),
        ];

        return Trip::create($details);
    }

    private function validate(Request $request){
        $rules = [
            'bus-id'=>'required',
            'start-at'=>'required',
            'start-from'=>'required|alpha|min:2',
            'destination'=>'required|alpha|min:2',
            'route-number'=>'required',
            'driver-id'=>'required',
            'conductor-id'=>'required',
        ];

        $messages = [
            'bus-id.required'=>'Bus ID field cannot be empty!',
            'start-at.required'=>'Start At field cannot be empty!',
            'start-from.required'=>'Start From field cannot be empty!',
            'start-from.alpha'=>'Start From field must only contain letters!',
            'start-from.min'=>'Start From field must contain at least 2 letters!',
            'destination.required'=>'Destination field cannot be empty!',
            'destination.alpha'=>'Destination field can contain only letters!',
            'destination.min'=>'Destination field should contain more than 2 letters!',
            'route-number.required'=>'Route Number field cannot be empty!',
            'driver-id.required'=>'Driver ID field cannot be empty!',
            'conductor-id.required'=>'Conductor ID field cannot be empty!',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    private function regularValidation(Request $request){
        $validator = $this->validate($request);
        $validator->validate();
    }

    private function ajaxValidate(Request $request){
        return $this->validate($request);
    }

    //Update trip
    public function update(Request $request){
        $trip = Trip::find($request->input('id'));
        if(is_null($trip)){
            return 'error';
        }

        $validator = $this->ajaxValidate($request);

        if($validator->fails()){
            return $validator->messages();
        }

        $trip->start_at = $request->input('start-at');
        $trip->start_from = $request->input('start-from');
        $trip->destination = $request->input('destination');
        $trip->route_number = $request->input('route-number');
        $trip->bus_number = $request->input('bus-id');
        $trip->driver_id = $request->input('driver-id');
        $trip->conductor_id = $request->input('conductor-id');
        $result = $trip->save();

        if($result){
            return 'success';
        }

        return 'error';
    }

    //Get trip based on id
    public function singleTrip($id){
        return Trip::find($id);
    }

    //Delete trip
    public function delete($id) {
        $trip = $this->singleTrip($id);
        $result = $trip->delete();
        if($result){
            return 'success';
        }

        return 'error';
    }
}