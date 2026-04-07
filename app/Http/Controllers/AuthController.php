<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(Request $request){
        $response = Http::post('http://localhost:8000/api/auth/login', [
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if($response->successful()){
            $result = $response->json();

            session([
                'api_token' => $result['data']['token'],
                'user_data' => $result['data']['user']
            ]);

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Invalid username or password.'
        ])->withInput();
    }

    public function logout(){
        session()->forget(['api_token', 'user_data']);
        return redirect('/login');
    }
}
