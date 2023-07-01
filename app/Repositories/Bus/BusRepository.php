<?php

namespace App\Repositories\Bus;

use App\Models\Bus;

class BusRepository implements BusRepositoryInterface{

    //get all buses
    public function all(){
        return Bus::paginate(2);
    }
}