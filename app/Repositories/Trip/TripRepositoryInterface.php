<?php

namespace App\Repositories\Trip;

use Illuminate\Http\Request;

interface TripRepositoryInterface{
    public function allWithPagination();

    public function add(Request $request);

    public function delete($id);

    public function singleTrip($id);

    public function update(Request $request);
}