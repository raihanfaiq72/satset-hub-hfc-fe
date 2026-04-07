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
        $publishedServices = array_filter($services, function($service) {
            return isset($service['release_status']) && $service['release_status'] === 'published';
        });

        $publishedServices = array_values($publishedServices);

        // echo json_encode($publishedServices);
        return view('services.index',[
            'services' => $publishedServices
        ]);
    }
}
