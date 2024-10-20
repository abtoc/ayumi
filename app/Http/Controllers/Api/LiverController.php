<?php

namespace App\Http\Controllers\Api;

use App\UseCases\Api\Liver\IndexAction;
use Illuminate\Http\Request;

class LiverController extends BaseController
{
    public function index(IndexAction $action)
    {
        return $this->sendResponse(
            'Liver',
            $action(),
        );
    }
}
