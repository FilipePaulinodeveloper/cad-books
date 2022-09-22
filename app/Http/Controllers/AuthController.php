<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        $array = ['error' => ''];

            $creds = $request->only('email', 'password');

            $token = Auth::attempt([$creds]);
            
            if($token){
                $array['token'] = $token;
            }else{
                $array['error'] = 'E-mail e/ou senha ou email incorretos.';
            }

        return $array;
    }
}
