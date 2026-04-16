<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        $voucherBatches = $this->api->getVoucherBatches();
        $vouchers = $this->api->getVouchers();

        $userPaymentVouchersData = [
            'user_id' => session('user_data')['id'],
        ];
        $userPaymentVouchers = $this->api->getUserPaymentVouchers($userPaymentVouchersData);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'vouchers' => $userPaymentVouchers
            ]);
        }

        return view('voucher.index', compact('voucherBatches', 'vouchers', 'userPaymentVouchers'));
    }

    public function buy(Request $request)
    {
        try {
            $voucherIds = $request->input('voucher_ids', []);

            $data = [
                'user_id' => session('user_data')['id'],
                'voucher_id' => $voucherIds,
                'status' => 'available',
            ];

            $result = $this->api->buyVoucher($data);

            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
