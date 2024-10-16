<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed'],
        ]);

        $email = $credentials['email'];
        $password = $credentials['password'];

        $credentials['password'] = Hash::make($credentials['password']);
        $credentials['locked'] = true;
        $user = User::create($credentials);

        Log::info(
            $user->name.'('.$user->email.')さんからユーザ登録がありました'
        );

        if(Auth::attempt(['email' =>$email, 'password' => $password], true)){
            $request->session()->regenerate();
            return redirect()->intended(route('api.loggedin'));
        }

        return $this->sendError(
            'Login Failed',
            ['email' => 'The provided credentials do not match our records.'],
            401,
        );
    }
}

