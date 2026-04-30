<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $data = [
                'username' => $request->username,
                'password' => $request->password,
            ];

            $response = $this->authService->login($data);

            if ($response) {
                session([
                    'api_token' => $response['token'],
                    'user_data' => $response['user'],
                ]);

                return redirect()->intended('/dashboard');
            }

            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors([
                'username' => $e->getMessage(),
            ])->withInput();
        }
    }

    public function logout()
    {
        session()->forget(['api_token', 'user_data']);

        return redirect('/login');
    }

    public function forgotPassword()
    {
        return view('auth.forgot');
    }

    public function forgotPasswordSendOTP(Request $request)
    {
        try {
            $data = [
                'noHp' => $request->noHp,
            ];

            $response = $this->authService->sendOtpForgotPassword($data);

            if ($response) {
                session(['noHp' => $request->noHp]);

                return redirect()->route('otp')->with('success', 'OTP telah dikirim ke nomor telepon Anda.');
            }

            return back()->withErrors([
                'noHp' => 'Nomor telepon tidak terdaftar.',
            ])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors([
                'noHp' => $e->getMessage(),
            ])->withInput();
        }
    }

    public function otp()
    {
        return view('auth.otp');
    }

    public function verifyOTP(Request $request)
    {
        try {
            $data = [
                'noHp' => $request->noHp,
                'otp' => $request->otp,
            ];

            $response = $this->authService->verifyOtp($data);

            if ($response) {
                return redirect()->route('password.reset')->with('success', 'OTP berhasil diverifikasi. Silakan atur ulang kata sandi Anda.');
            }

            return back()->withErrors([
                'otp' => 'Kode OTP tidak valid.',
            ])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors([
                'otp' => $e->getMessage(),
            ])->withInput();
        }
    }

    public function resetPassword()
    {
        return view('auth.reset');
    }

    public function updatePassword(Request $request)
    {
        try {
            $data = [
                'noHp' => $request->noHp,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
            ];

            $response = $this->authService->resetPassword($data);

            if ($response) {
                return redirect()->route('login')->with('success', 'Kata sandi berhasil diperbarui. Silakan login dengan kata sandi baru Anda.');
            }

            return back()->withErrors([
                'password' => 'Gagal memperbarui kata sandi. Silakan coba lagi.',
            ])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors([
                'password' => $e->getMessage(),
            ])->withInput();
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerUser(Request $request)
    {
        try {
            $data = [
                'username' => $request->username,
                'noHp' => $request->noHp,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
            ];

            $response = $this->authService->register($data);

            if ($response) {
                return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Silakan login dengan akun baru Anda.');
            }

            return back()->withErrors([
                'username' => 'Gagal mendaftar. Silakan coba lagi.',
            ])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors([
                'username' => $e->getMessage(),
            ])->withInput();
        }
    }
}
