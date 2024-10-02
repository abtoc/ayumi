<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends BaseController
{
    /**
     * returns list of users.
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all();
        return $this->sendResponse('successfully fetched.', $users->toArray());
    }
}
