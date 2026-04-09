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

    public function forgotPassword(){
        return view('auth.forgot');
    }

    public function forgotPasswordSendOTP(Request $request){
        $response = Http::post('http://localhost:8000/api/auth/otp-forgot-password', [
            'noHp' => $request->noHp,
        ]);

        if($response->successful()){
            session(['noHp' => $request->noHp]);
            return redirect()->route('otp')->with('success', 'OTP sent to your phone number.');
        }

        return back()->withErrors([
            'noHp' => 'Phone number not found.'
        ])->withInput();
    }

    public function otp(){
        return view('auth.otp');
    }

    public function verifyOTP(Request $request){
        $response = Http::post('http://localhost:8000/api/auth/verify-otp', [
            'noHp' => $request->noHp,
            'otp' => $request->otp,
        ]);

        if($response->successful()){
            return redirect()->route('password.reset')->with('success', 'OTP verified. You can now reset your password.');
        }

        return back()->withErrors([
            'otp' => 'Invalid OTP.'
        ])->withInput();
    }

    public function resetPassword(){
        return view('auth.reset');
    }

    public function updatePassword(Request $request){
        $response = Http::post('http://localhost:8000/api/auth/reset-password', [
            'noHp' => $request->noHp,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        if($response->successful()){
            return redirect()->route('login')->with('success', 'Password reset successful. Please login with your new password.');
        }

        return back()->withErrors([
            'password' => 'Failed to reset password. Please try again.'
        ])->withInput();
    }

    public function register(){
        return view('auth.register');
    }

    public function registerUser(Request $request){
        $response = Http::post('http://localhost:8000/api/auth/register', [
            'username' => $request->username,
            'noHp' => $request->noHp,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        if($response->successful()){
            return redirect()->route('login')->with('success', 'Registration successful. Please login with your new account.');
        }

        return back()->withErrors([
            'email' => 'Failed to register. Please try again.'
        ])->withInput();
    }
}
