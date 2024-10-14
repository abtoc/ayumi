<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends BaseController
{
    public function logout(Request $request)
    {
        if (Auth::guest()){
            return $this->sendResponse(
                'Logged out.',
                ['email' => 'Unauthenticated.'],
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->sendResponse(
            'Logged out.',
            ['email' => 'Unauthenticated.'],
        );
    }
}
