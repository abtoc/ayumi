<?php

namespace App\Http\Controllers\Api;

use App\UseCases\Api\VisitAction;
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
            'Visit',
            $result,
        );
    }
}
