<?php

namespace App\Http\Controllers\Expressway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //get report view
    public function index(){
        return view('functions.reports');
    }
}
