<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        logger()->info($email);
        logger()->info($password);

        $credentials['password'] = Hash::make($credentials['password']);
        $credentials['locked'] = true;
        User::create($credentials);

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

