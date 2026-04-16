<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Exception;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $services = $this->api->getServices();

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

        return view('services.index', [
            'serviceParents' => array_values($serviceParents),
        ]);
    }

    public function show($kode)
    {
        $service = $this->api->getServiceDetail($kode);

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
        $userLocations = $this->api->getUserLocations($data);
        $service = $this->api->getServiceDetail($kode);

        return view('services.book', [
            'kode' => $kode,
            'api_token' => session('api_token'),
            'user_locations' => $userLocations,
            'service' => $service,
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
            $response = $this->api->createLokasi($data);

            return redirect()->route('services.book', $kode)->with([
                'success' => 'Lokasi berhasil ditambahkan!',
                'new_address_id' => $response['Id'] ?? null,
                'p_date' => $request->date,
                'p_time' => $request->time,
                'p_step' => 2,
            ]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Gagal menambahkan lokasi: '.$e->getMessage()])->withInput();
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
            $response = $this->api->checkAvailableRanger($data);

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
        $request->validate([
            'idCustomer' => 'required',
            'idLayanan' => 'required',
            'tglPekerjaan' => 'required|date_format:Y-m-d H:i:s',
            'idSubLayanan' => 'required',
            'idLokasi' => 'required',
        ]);

        $data = $request->all();

        try {
            $response = $this->api->createNewOrder($data);

            // If payment_voucher_id is provided, redeem it now
            if ($request->filled('payment_voucher_id')) {
                $this->api->usePaymentVoucher([
                    'user_id' => $data['idCustomer'],
                    'voucher_id' => $request->voucher_id,
                    'layanan_id' => $data['idLayanan'],
                ]);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $response,
                ]);
            }

            return redirect()->route('services.book', $kode)->with([
                'success' => 'Pesanan berhasil dibuat!',
                'p_step' => 4,
                'order_id' => $response['id'] ?? null,
            ]);
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 500);
            }

            return back()->withErrors(['error' => 'Gagal membuat pesanan: '.$e->getMessage()])->withInput();
        }
    }

    public function useVoucher(Request $request)
    {
        $request->validate([
            'payment_voucher_id' => 'required',
            'layanan_id' => 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = session('user_data')['id'];

        try {
            $response = $this->api->usePaymentVoucher($data);

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
