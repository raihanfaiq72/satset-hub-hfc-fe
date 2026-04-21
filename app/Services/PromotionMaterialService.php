<?php

namespace App\Services;

use Carbon\Carbon;

class PromotionMaterialService extends ApiService
{
    public function getBanners()
    {
        return $this->request('get', 'banners');
    }

    public function getActivePromoModal()
    {
        $modals = $this->request('get', 'promosi-modals');

        // Find first active modal within date range
        $now = Carbon::now();
        foreach ($modals as $modal) {
            if (($modal['is_active'] ?? 0) == 1) {
                $start = isset($modal['mulai_tampil']) ? Carbon::parse($modal['mulai_tampil']) : null;
                $end = isset($modal['selesai_tampil']) ? Carbon::parse($modal['selesai_tampil']) : null;

                if ((! $start || $now >= $start) && (! $end || $now <= $end)) {
                    return $modal;
                }
            }
        }

        return null;
    }
}
