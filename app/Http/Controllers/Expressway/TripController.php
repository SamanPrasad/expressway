<?php

namespace App\Http\Controllers\Expressway;

use App\Http\Controllers\Controller;
use App\Repositories\Bus\BusRepositoryInterface;
use App\Repositories\Route\RouteRepositoryInterface;
use App\Repositories\Trip\TripRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class TripController extends Controller
{
    protected $tripRepository;
    protected $busRepository;
    protected $userRepository;
    protected $routeRepository;

    public function __construct(
        TripRepositoryInterface $tripRepository, 
        BusRepositoryInterface $busRepository, 
        UserRepositoryInterface $userRepository,
        RouteRepositoryInterface $routeRepository)
    {
        $this->tripRepository = $tripRepository;        
        $this->busRepository = $busRepository;        
        $this->userRepository = $userRepository;        
        $this->routeRepository = $routeRepository;        
    }

    public function index(){
        $trips = $this->tripRepository->allWithPagination();
        $drivers = $this->userRepository->userWithRole('Driver');
        $conductors = $this->userRepository->userWithRole('Conductor');
        $buses = $this->busRepository->all();
        $routes = $this->routeRepository->all()->sortBy('route_number');
        return view('functions.trips')
                    ->with('trips', $trips)
                    ->with('drivers', $drivers)
                    ->with('conductors', $conductors)
                    ->with('buses', $buses)
                    ->with('routes', $routes);
    }

    //create new schedule
    public function create(Request $request){
        $trip = $this->tripRepository->add($request);

        if(is_null($trip)){
            return 'error';
        }

        return redirect()->back()->with('message', 'Bus scheduled successfully !');
    }

    //Delete trip
    public function destroy($id){
        return $this->tripRepository->delete($id);
    }

    //Get trip based on id
    public function singleTrip(Request $request){
        $trip = $this->tripRepository->singleTrip($request->input('id'));
        $buses = $this->busRepository->all();
        $routes = $this->routeRepository->all();
        $drivers = $this->userRepository->userWithRole('Driver');
        $conductors = $this->userRepository->userWithRole('Conductor');

        return [
            'trip'=> $trip,
            'buses'=> $buses,
            'routes'=> $routes,
            'drivers'=> $drivers,
            'conductors'=> $conductors,
        ];
    }

    //Update trip
    public function update(Request $request){
        return $this->tripRepository->update($request);
    }
}
