<?php

namespace App\Services;

class AuthService extends ApiService
{
    public function login($data)
    {
        return $this->request('post', 'auth/login', $data, false);
    }

    public function sendOtpForgotPassword($data)
    {
        return $this->request('post', 'auth/otp-forgot-password', $data, false);
    }

    public function verifyOtp($data)
    {
        return $this->request('post', 'auth/verify-otp', $data, false);
    }

    public function resetPassword($data)
    {
        return $this->request('post', 'auth/reset-password', $data, false);
    }

    public function register($data)
    {
        return $this->request('post', 'auth/register', $data, false);
    }
}
