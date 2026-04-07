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
        if (!$this->token) {
            throw new \Exception('No API token in session');
        }

        $response = Http::withToken($this->token)->$method("http://localhost:8000/api/$endpoint", $data);

        if ($response->status() == 401) {
            session()->forget(['api_token', 'user_data']);
            throw new \Exception('Unauthorized');
        }

        if (!$response->successful()) {
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
}