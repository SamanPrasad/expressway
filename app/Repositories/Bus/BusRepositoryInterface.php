<?php

namespace App\Repositories\Bus;

use Illuminate\Http\Request;

interface BusRepositoryInterface{
    public function all();

    public function add(Request $request);

    public function singleBus($id);

    public function update(Request $request);
}