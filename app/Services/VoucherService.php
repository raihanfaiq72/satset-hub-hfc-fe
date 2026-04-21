<?php

namespace App\Services;

class VoucherService extends ApiService
{
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

    public function usePaymentVoucher($data)
    {
        return $this->request('post', 'payment-vouchers/user-use', $data);
    }

    public function getUserPromoVouchers($data)
    {
        return $this->request('get', 'promo-vouchers/user', $data);
    }

    public function scanAndTransferVoucher($data)
    {
        return $this->request('post', 'qr-code/scan-and-transfer', $data);
    }

    public function generateReceiveQr($data)
    {
        return $this->request('post', 'qr-code/generate-receive', $data);
    }
}
