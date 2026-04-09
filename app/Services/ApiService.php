<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    protected $token;

    public function __construct()
    {
        $this->token = session('api_token');
    }

    protected function request($method, $endpoint, $data = [])
    {
        if (! $this->token) {
            throw new \Exception('No API token in session');
        }

        $url = "http://localhost:8000/api/$endpoint";

        if (strtolower($method) === 'get' && ! empty($data)) {
            $response = Http::withToken($this->token)
                ->withBody(json_encode($data), 'application/json')
                ->send('GET', $url);
        } else {
            $response = Http::withToken($this->token)->$method($url, $data);
        }

        if ($response->status() == 401) {
            session()->forget(['api_token', 'user_data']);
            throw new \Exception('Unauthorized');
        }

        if (! $response->successful()) {
            throw new \Exception('API request failed');
        }

        return $response->json()['data'] ?? [];
    }

    public function getBanners()
    {
        return $this->request('get', 'banners');
    }

    public function getServices()
    {
        return $this->request('get', 'layanan');
    }

    public function getServiceDetail($kode)
    {
        return $this->request('get', "layanan/$kode");
    }

    public function getVoucherBatches()
    {
        return $this->request('get', 'payment-vouchers/batches');
    }

    public function getVouchers()
    {
        return $this->request('get', 'payment-vouchers');
    }

    public function buyVoucher($data)
    {
        return $this->request('post', 'payment-vouchers/user-buy', $data);
    }

    public function getUserPaymentVouchers($data)
    {
        return $this->request('get', 'payment-vouchers/user', $data);
    }

    public function createLokasi($data)
    {
        return $this->request('post', 'lokasi/create', $data);
    }

    public function getUserLocations($data)
    {
        return $this->request('get', 'lokasi', $data);
    }
}
