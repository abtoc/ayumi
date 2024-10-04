<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\UseCases\Api\Home\HomeAction;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function home(Request $request, HomeAction $action)
    {
        $input = $request->validate([
            'date' => ['nullable','date']
        ]);

        $result = $action($input);

        return $this->sendResponse(
            'Home',
            $result,
        );
    }
}
