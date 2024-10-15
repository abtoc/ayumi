<?php

namespace App\Http\Controllers\Api;

use App\UseCases\Api\Shortcut\IndexAction;
use Illuminate\Http\Request;

class ShortcutController extends BaseController
{
    public function index(Request $request, IndexAction $action)
    {
        $result = $action();

        return $this->sendResponse(
            'Scrennshot',
            $result,
        );
    }
}
