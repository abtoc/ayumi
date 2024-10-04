<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\UseCases\Api\Visit\VisitAction;
use Illuminate\Http\Request;

class VisitController extends BaseController
{
    public function visit(Request $request, VisitAction $action)
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
