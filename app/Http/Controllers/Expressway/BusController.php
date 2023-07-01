<?php

namespace App\Http\Controllers\Expressway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusController extends Controller
{
    //get bus view
    public function index(){
        return view('functions.buses');
    }
}
