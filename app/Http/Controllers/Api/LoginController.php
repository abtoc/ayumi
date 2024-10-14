<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    /**
     * authenticate with credentials.
     * route: post('/api/login')
     *
     * @param   Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            return redirect()->intended(route('api.loggedin'));
        }

        return $this->sendError(
            'Login Failed',
            ['email' => 'The provided credentials do not match our records.'],
            401,
        );
    }

    public function loggedin()
    {
        return $this->sendResponse(
            'Logged in.',
            Auth::user()->toArray(),
        );
    }

}
