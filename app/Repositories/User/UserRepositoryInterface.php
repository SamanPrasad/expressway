<?php

namespace App\Repositories\User;

use Illuminate\Http\Request;

interface UserRepositoryInterface{
    public function allWithPagination();

    public function all();

    public function add(Request $request);

    public function update(Request $request);

    public function singleUser($id);

    public function delete($id);

    public function userWithRole($role);
}