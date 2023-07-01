<?php

namespace App\Repositories\User;

use Illuminate\Http\Request;

interface UserRepositoryInterface{
    public function all();

    public function add(Request $request);

    public function update(Request $request);

    public function user($id);
}