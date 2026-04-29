<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Services\PromotionMaterialService;
use App\Services\VoucherService;
use Exception;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $orderService;

    protected $promotionMaterialService;

    protected $voucherService;

    public function __construct(
        OrderService $orderService,
        PromotionMaterialService $promotionMaterialService,
        VoucherService $voucherService
    ) {
        $this->orderService = $orderService;
        $this->promotionMaterialService = $promotionMaterialService;
        $this->voucherService = $voucherService;
    }

    public function index()
    {
        $services = $this->orderService->getServices();

        $serviceParents = array_filter($services, function ($service) {
            return $service['release_status'] === 'published';
        });

        foreach ($serviceParents as &$parent) {
            if (! empty($parent['children'])) {
                $parent['children'] = array_filter($parent['children'], function ($child) {
                    return $child['release_status'] === 'published';
                });
                $parent['children'] = array_values($parent['children']);
            }
        }
        unset($parent);

        // Get active promo modal
        $promoModal = null;
        try {
            $promoModal = $this->promotionMaterialService->getActivePromoModal();
        } catch (Exception $e) {
            // Silent fail - modal tidak akan ditampilkan jika error
        }

        return view('services.index', [
            'serviceParents' => array_values($serviceParents),
            'promoModal' => $promoModal,
        ]);
    }

    public function show($kode)
    {
        $service = $this->orderService->getServiceDetail($kode);

        // echo json_encode($service);

        return view('services.detail', [
            'service' => $service,
        ]);
    }

    public function book($kode)
    {
        $data = [
            'user_id' => session('user_data')['id'] ?? null,
        ];
        $userLocations = $this->orderService->getUserLocations($data);
        $service = $this->orderService->getServiceDetail($kode);
        $baseUrl = config('services.api_url');

        return view('services.book', [
            'kode' => $kode,
            'api_token' => session('api_token'),
            'user_locations' => $userLocations,
            'service' => $service,
            'api_base_url' => $baseUrl,
        ]);
    }

    public function storeLocation(Request $request, $kode)
    {
        $request->validate([
            'NamaLokasi' => 'required',
            'alamat' => 'required',
            'RT' => 'required',
            'RW' => 'required',
            'idProvince' => 'required',
            'idRegencies' => 'required',
            'idDistricts' => 'required',
            'idVillages' => 'required',
            'namaPIC' => 'required',
            'noHpPIC' => 'required',
            'jenisBangunan' => 'required',
        ]);

        $data = $request->all();
        $data['idCustomer'] = session('user_data')['id'] ?? null;

        if (! $data['idCustomer']) {
            return back()->withErrors(['error' => 'Sesi pengguna tidak valid. Silakan login kembali.'])->withInput();
        }

        try {
            $response = $this->orderService->createLokasi($data);

            return redirect()->route('services.book', $kode)->with([
                'success' => 'Lokasi berhasil ditambahkan!',
                'new_address_id' => $response['Id'] ?? null,
                'p_date' => $request->date,
                'p_time' => $request->time,
                'p_step' => 2,
            ]);
        } catch (Exception $e) {
            return back()->with([
                'p_step' => 21,
                'p_date' => $request->date,
                'p_time' => $request->time,
            ])->withErrors(['error' => 'Gagal menambahkan lokasi: '.$e->getMessage()])->withInput();
        }
    }

    public function checkAvailableRanger(Request $request)
    {
        $request->validate([
            'tgl' => 'required|date',
            'jam' => 'required|date_format:H:i',
        ]);

        $data = $request->all();

        try {
            $response = $this->orderService->checkAvailableRanger($data);

            return response()->json([
                'success' => true,
                'data' => $response,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function createNewOrder(Request $request, $kode)
    {
        $idLayanan = $request->idLayanan;
        $duration = $request->input('duration', 3);
        $staffCount = $request->input('staffCount', 1);

        $data = [
            'idCustomer' => $request->idCustomer,
            'idLayanan' => $idLayanan,
            'tglPekerjaan' => $request->tglPekerjaan,
            'idSubLayanan' => $request->idSubLayanan,
            'idLokasi' => $request->idLokasi,
            'payment_method' => $request->payment_method,
            'metodePembayaran' => $request->metodePembayaran,
        ];

        // Override idLayanan based on duration
        if ($duration == 3) {
            $data['idLayanan'] = 6;
        } elseif ($duration == 6) {
            $data['idLayanan'] = 7;
        }

        try {
            $responses = [];
            $selectedVoucherIds = $request->input('payment_voucher_ids', []);
            $selectedVoucherCodes = $request->input('payment_voucher_codes', []);

            // Fallback to single ID if provided
            if (empty($selectedVoucherIds) && $request->filled('payment_voucher_id')) {
                $selectedVoucherIds = [$request->payment_voucher_id];
            }

            $vouchersPerOrder = $duration / 3;
            $voucherIndex = 0;

            for ($i = 0; $i < $staffCount; $i++) {
                $orderPayload = $data;

                // If we have a voucher for this order, attach its info
                if (isset($selectedVoucherIds[$voucherIndex])) {
                    $orderPayload['payment_method'] = 'Voucher';
                    $orderPayload['metodePembayaran'] = 'Voucher Pembayaran';
                    $orderPayload['voucher_type'] = $request->input('voucher_type', 1);
                    if (isset($selectedVoucherCodes[$voucherIndex])) {
                        $orderPayload['voucher_code'] = $selectedVoucherCodes[$voucherIndex];
                    }
                }

                $response = $this->orderService->createNewOrder($orderPayload);
                $responses[] = $response;

                // Redeem vouchers for this order
                for ($v = 0; $v < $vouchersPerOrder; $v++) {
                    if (isset($selectedVoucherIds[$voucherIndex])) {
                        try {
                            $this->voucherService->usePaymentVoucher([
                                'user_id' => $data['idCustomer'],
                                'voucher_id' => $selectedVoucherIds[$voucherIndex],
                                'layanan_id' => $idLayanan,
                                'voucher_type' => $request->input('voucher_type', 1),
                            ]);
                            $voucherIndex++;
                        } catch (Exception $ve) {
                            // If one voucher fails, we might want to continue or log
                        }
                    }
                }
            }

            $finalResponse = end($responses);

            return response()->json([
                'success' => true,
                'data' => $finalResponse,
                'orders_created' => count($responses),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function useVoucher(Request $request)
    {
        $request->validate([
            'voucher_id' => 'required',
            'layanan_id' => 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = session('user_data')['id'];

        try {
            $response = $this->voucherService->usePaymentVoucher($data);

            return response()->json([
                'success' => true,
                'data' => $response,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
