<?php

namespace App\Http\Controllers;

use App\Services\VoucherService;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    protected $api;

    public function __construct(VoucherService $api)
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
                'vouchers' => $userPaymentVouchers,
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

    public function receive()
    {
        return view('voucher.receive');
    }

    public function giftScan(Request $request)
    {
        $userData = session('user_data');
        if (! $userData) {
            return redirect()->route('login');
        }

        $data = ['user_id' => $userData['id']];
        $paymentVouchers = $this->api->getUserPaymentVouchers($data);
        $promoVouchers = $this->api->getUserPromoVouchers($data);

        $selectedVoucherId = $request->query('voucher_id');
        $selectedVoucherType = $request->query('voucher_type');

        return view('voucher.gifting.scan', compact('paymentVouchers', 'promoVouchers', 'selectedVoucherId', 'selectedVoucherType'));
    }

    public function processGift(Request $request)
    {
        try {
            $data = [
                'qr_code' => $request->input('qr_code'),
                'voucher_type' => $request->input('voucher_type'),
                'voucher_id' => $request->input('voucher_id'),
                'otp' => $request->input('otp'),
            ];

            $result = $this->api->scanAndTransferVoucher($data);

            return response()->json([
                'success' => true,
                'message' => 'Voucher berhasil dikirim!',
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function scanAndSendOtp(Request $request)
    {
        try {
            $data = [
                'qr_code' => $request->input('qr_code'),
            ];

            $result = $this->api->scanAndSendOtp($data);

            return response()->json([
                'success' => isset($result['status']) ? $result['status'] === 'success' : true,
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            
            // If the error is specifically about WhatsApp failing, we treat it as a "soft success"
            // because the OTP session was already created in the database and the Giver can 
            // still proceed if they can find the OTP (e.g. from logs).
            if (str_contains($message, 'Failed to send OTP via WhatsApp')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Scan berhasil, namun pengiriman WhatsApp tertunda. Silakan cek OTP secara manual.',
                    'soft_error' => $message
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $message,
            ], 500);
        }
    }

    public function generateReceiveQr(Request $request)
    {
        $userData = session('user_data');
        if (! $userData) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        try {
            $data = ['user_id' => $userData['id']];
            $response = $this->api->generateReceiveQr($data);

            return response()->json([
                'status' => 'success',
                'data' => $response,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkOtpStatus(Request $request)
    {
        $userData = session('user_data');
        if (! $userData) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        try {
            $data = ['user_id' => $userData['id']];
            $response = $this->api->checkOTPStatus($data);

            return response()->json([
                'success' => isset($response['scanned']),
                'data' => $response,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
