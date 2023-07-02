<?php

namespace App\Http\Controllers\Expressway;

use App\Http\Controllers\Controller;
use App\Repositories\Route\RouteRepositoryInterface;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    private $routeRepository;

    public function __construct(RouteRepositoryInterface $routeRepository)
    {
        $this->routeRepository = $routeRepository;        
    }

    public function index(){
        $routes = $this->routeRepository->all();
        return view('functions.routes')->with('routes', $routes);
    }

    //Add new route
    public function create(Request $request){
        $route = $this->routeRepository->add($request);
        if(is_null($route)){
            return 'error';
        }

        return redirect()->back()->with('message', 'Route added successfully !');
    }

    //Update route
    public function update(Request $request){
        return $this->routeRepository->update($request);
    }

    //Delete route
    public function destroy($id){
        return $this->routeRepository->delete($id);
    }

    //Get single route based on id
    public function singleRoute(Request $request){
        return $this->routeRepository->singleRoute($request->input('id'));
        // dd($this->routeRepository->singleRoute($request->input('id')));

    }
}
