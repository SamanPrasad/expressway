<?php

namespace App\Http\Controllers\Expressway;

use App\Http\Controllers\Controller;
use App\Repositories\Bus\BusRepositoryInterface;
use Illuminate\Http\Request;

class BusController extends Controller
{
    private $busRepository;

    public function __construct(BusRepositoryInterface $busRepository)
    {
        $this->busRepository = $busRepository;
    }

    //get bus view
    public function index(){
        $buses = $this->busRepository->all();
        return view('functions.buses')->with('buses', $buses);
    }

    //add new bus
    public function create(Request $request){
        $bus = $this->busRepository->add($request);
        if(is_null($bus)){
            return 'error';
        }

        return redirect()->back()->with('message', 'Bus added successfully !');
    }

    //Update bus
    public function update(Request $request){
        return $this->busRepository->update($request);
    }

    //Delete bus
    public function destroy($id){
        $bus = $this->busRepository->singleBus($id);

        if(is_null($bus)){
            return 'error';
        }

        $result = $bus->delete();

        if($result){
            return 'success';
        }

        return 'error';
    }

    //Get bus details based on id
    public function singleBus(Request $request){
        return $this->busRepository->singleBus($request->input('id'));
    }
}
