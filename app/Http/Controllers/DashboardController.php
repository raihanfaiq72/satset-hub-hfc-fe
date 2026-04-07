<?php

namespace App\Http\Controllers;

use App\Services\ApiService;

class DashboardController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        try {
            $banners = $this->api->getBanners();
            $services = $this->api->getServices();

            usort($banners, function($a, $b) {
                return $a['urutan'] <=> $b['urutan'];
            });

            $serviceParents = array_values(array_filter($services, function($item) {
                return $item['idParent'] == 0 && $item['release_status'] === 'published';
            }));

            $allChildren = [];
            foreach ($services as $service) {
                if (!empty($service['children'])) {
                    foreach ($service['children'] as $child) {
                        if ($child['release_status'] === 'published') {
                            $allChildren[] = $child;
                        }
                    }
                }
            }

            return view('dashboard.index', [
                'banners' => $banners,
                'user' => session('user_data'),
                'serviceParents' => $serviceParents,
                'allChildren' => $allChildren
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}