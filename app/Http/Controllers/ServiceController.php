<?php

namespace App\Http\Controllers;

use App\Services\ApiService;

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
        ]);
    }
}
