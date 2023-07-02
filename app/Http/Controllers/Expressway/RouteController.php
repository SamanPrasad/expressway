<?php

namespace App\Http\Controllers\Expressway;

use App\Http\Controllers\Controller;
use App\Repositories\Route\RouteRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    private $routeRepository;

    public function __construct(RouteRepositoryInterface $routeRepository)
    {
        $this->routeRepository = $routeRepository;        
    }

    public function index(){
        $routes = $this->routeRepository->allWithPagination();
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
        if(Auth::check()){
            return $this->routeRepository->delete($id);
        }

        return redirect('/');
    }

    //Get single route based on id
    public function singleRoute(Request $request){
        return $this->routeRepository->singleRoute($request->input('id'));
    }
}
