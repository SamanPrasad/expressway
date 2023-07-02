<?php

namespace App\Repositories\Route;

use Illuminate\Http\Request;

interface RouteRepositoryInterface{
    public function all();

    public function add(Request $request);

    public function singleRoute($id);

    public function update(Request $request);

    public function delete($id);
}