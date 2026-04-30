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
                if ($service['idParent'] == 0 && $service['release_status'] === 'published') {
                    $allChildren[] = $service;
                }
            }

            // Get active promo modal
            $promoModal = null;
            try {
                $promoModal = $this->promotionMaterialService->getActivePromoModal();
            } catch (\Exception $e) {
                // Silent fail - modal tidak akan ditampilkan jika error
            }

            $history = $this->orderService->getOrderHistory(['user_id' => session('user_data')['id']]);

            // Use grouping logic from HistoryController
            $groupedHistory = HistoryController::groupOrders($history);
            $lastActivities = $groupedHistory->take(3);

            $serviceMap = [];
            foreach ($services as $s) {
                $serviceMap[$s['id']] = $s['keterangan'];
                if (! empty($s['children'])) {
                    foreach ($s['children'] as $c) {
                        $serviceMap[$c['id']] = $c['keterangan'];
                    }
                }
            }

            $mappedActivities = [];
            foreach ($lastActivities as $group) {
                $activity = $group->first();
                $staffCount = $group->count();

                $activity['service_name'] = $serviceMap[$activity['idLayanan'] ?? 0] ?? 'Layanan SatSet';
                $activity['sub_service_name'] = ($serviceMap[$activity['idSubLayanan'] ?? 0] ?? 'Cleaning')." ($staffCount Personel)";

                $mappedActivities[] = $activity;
            }

            return view('dashboard.index', [
                'banners' => $banners,
                'user' => session('user_data'),
                'serviceParents' => $serviceParents,
                'allChildren' => $allChildren,
                'promoModal' => $promoModal,
                'lastActivities' => $mappedActivities,
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
