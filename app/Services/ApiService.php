<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

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

        if (strtolower($method) === 'get') {
            $request = Http::withToken($this->token)->accept('application/json');

            if (! empty($data)) {
                $response = $request->withBody(json_encode($data), 'application/json')->send('GET', $url);
            } else {
                $response = $request->get($url);
            }
        } else {
            $response = Http::withToken($this->token)
                ->accept('application/json')
                ->asJson()
                ->$method($url, $data);
        }

        if ($response->status() == 401) {
            session()->forget(['api_token', 'user_data']);
            throw new \Exception('Unauthorized');
        }

        if (! $response->successful()) {
            $status = $response->status();
            $body = $response->body();
            throw new \Exception("API request failed: HTTP $status - $body");
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

    public function getOrderHistory($data = [])
    {
        return $this->request('get', 'order/history', $data);
    }

    public function createLokasi($data)
    {
        return $this->request('post', 'lokasi/create', $data);
    }

    public function getUserLocations($data)
    {
        return $this->request('get', 'lokasi', $data);
    }

    public function checkAvailableRanger($data)
    {
        return $this->request('post', 'order/check-available-ranger', $data);
    }

    public function getActivePromoModal()
    {
        $modals = $this->request('get', 'promosi-modals');

        // Find first active modal within date range
        $now = Carbon::now();
        foreach ($modals as $modal) {
            if (($modal['is_active'] ?? 0) == 1) {
                $start = isset($modal['mulai_tampil']) ? Carbon::parse($modal['mulai_tampil']) : null;
                $end = isset($modal['selesai_tampil']) ? Carbon::parse($modal['selesai_tampil']) : null;

                if ((!$start || $now >= $start) && (!$end || $now <= $end)) {
                    return $modal;
                }
            }
        }

        return null;
    }

    public function createNewOrder($data)
    {
        return $this->request('post', 'order', $data);
    }

    public function getOrderDetail($id)
    {
        return $this->request('get', "order/detail/$id");
    }

    public function usePaymentVoucher($data)
    {
        return $this->request('post', 'payment-vouchers/user-use', $data);
    }

    public function getPromoVouchers()
    {
        return $this->request('get', 'promo-vouchers');
    }
}
