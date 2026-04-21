<?php

namespace App\Services;

class OrderService extends ApiService
{
    public function getServices()
    {
        return $this->request('get', 'layanan');
    }

    public function getServiceDetail($kode)
    {
        return $this->request('get', "layanan/$kode");
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

    public function createNewOrder($data)
    {
        return $this->request('post', 'order', $data);
    }

    public function getOrderDetail($id)
    {
        return $this->request('get', "order/detail/$id");
    }
}
