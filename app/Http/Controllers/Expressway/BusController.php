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
        return view('functions.buses.buses')->with('buses', $buses);
    }
}
