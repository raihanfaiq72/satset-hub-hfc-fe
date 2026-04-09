<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
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
        return view('services.book', [
            'kode' => $kode,
            'api_token' => session('api_token'),
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
                'p_step' => 3,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menambahkan lokasi: '.$e->getMessage()])->withInput();
        }
    }
}
