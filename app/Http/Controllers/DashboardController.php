<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Services\PromotionMaterialService;

class DashboardController extends Controller
{
    protected $promotionMaterialService;

    protected $orderService;

    public function __construct(PromotionMaterialService $promotionMaterialService,
        OrderService $orderService)
    {
        $this->promotionMaterialService = $promotionMaterialService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        try {
            $banners = $this->promotionMaterialService->getBanners();
            $services = $this->orderService->getServices();

            usort($banners, function ($a, $b) {
                return $a['urutan'] <=> $b['urutan'];
            });

            $serviceParents = array_values(array_filter($services, function ($item) {
                return $item['idParent'] == 0 && $item['release_status'] === 'published';
            }));

            $allChildren = [];
            foreach ($services as $service) {
                if (! empty($service['children'])) {
                    foreach ($service['children'] as $child) {
                        if ($child['release_status'] === 'published') {
                            $allChildren[] = $child;
                        }
                    }
                }
            }

            // Get active promo modal
            $promoModal = null;
            try {
                $promoModal = $this->promotionMaterialService->getActivePromoModal();
            } catch (\Exception $e) {
                // Silent fail - modal tidak akan ditampilkan jika error
            }

            return view('dashboard.index', [
                'banners' => $banners,
                'user' => session('user_data'),
                'serviceParents' => $serviceParents,
                'allChildren' => $allChildren,
                'promoModal' => $promoModal,
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
