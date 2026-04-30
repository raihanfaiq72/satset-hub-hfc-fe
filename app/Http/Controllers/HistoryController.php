<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Carbon\Carbon;
use Exception;

class HistoryController extends Controller
{
    protected $api;

    public function __construct(OrderService $api)
    {
        $this->api = $api;
    }

    public function show($id)
    {
        try {
            $orders = $this->api->getOrderHistory([
                'user_id' => session('user_data')['id'],
            ]);

            $order = collect($orders)->firstWhere('id', $id);

            if (! $order) {
                return redirect()->route('history.index')->withErrors(['error' => 'Pesanan tidak ditemukan.']);
            }

            // Calculate staff count using static group method
            $groupedOrders = self::groupOrders($orders);
            $groupKey = $order['idLayanan'].'-'.$order['idSubLayanan'].'-'.$order['tglPekerjaan'].'-'.$order['idLokasi'];
            $staffCount = isset($groupedOrders[$groupKey]) ? $groupedOrders[$groupKey]->count() : 1;

            // Resolve service names for the detail view
            $services = $this->api->getServices();
            $serviceMap = [];
            foreach ($services as $s) {
                $serviceMap[$s['id']] = $s['keterangan'];
                if (! empty($s['children'])) {
                    foreach ($s['children'] as $c) {
                        $serviceMap[$c['id']] = $c['keterangan'];
                    }
                }
            }

            $address = data_get($order, 'inquiry.lokasi.alamat');
            $rt = data_get($order, 'inquiry.lokasi.RT', 0);
            $rw = data_get($order, 'inquiry.lokasi.RW', 0);
            $province = ucwords(strtolower(data_get($order, 'inquiry.lokasi.province.name')));
            $regency = ucwords(strtolower(data_get($order, 'inquiry.lokasi.regency.name')));
            $district = ucwords(strtolower(data_get($order, 'inquiry.lokasi.district.name')));
            $village = ucwords(strtolower(data_get($order, 'inquiry.lokasi.village.name')));
            $fullAddress = "$address, RT $rt, RW $rw, $village, $district, $regency, $province";

            $unitPrice = (float) data_get($order, 'inquiry.finalPrice', 0);
            $totalPrice = ($unitPrice * $staffCount) + 5000;

            // Map API response to view format
            $mappedOrder = [
                'id' => $order['id'],
                'code' => data_get($order, 'inquiry.kodeInquiry', 'ORD-'.$order['id']),
                'service_code' => data_get($order, 'inquiry.layanan.kode', 'HFC'),
                'service' => $serviceMap[$order['idLayanan'] ?? 0] ?? 'Home & Facility Cleaning',
                'job_type' => $serviceMap[$order['idSubLayanan'] ?? 0] ?? 'Cleaning',
                'duration' => $order['idSubLayanan'] == 7 ? 6 : 3,
                'staff_count' => $staffCount,
                'status' => $this->getStatusLabel(data_get($order, 'status')),
                'date' => data_get($order, 'tglPekerjaan')
                    ? Carbon::parse($order['tglPekerjaan'])->translatedFormat('d M Y, H:i').' WIB'
                    : Carbon::parse($order['tglOrder'])->translatedFormat('d M Y, H:i').' WIB',
                'payment_method' => data_get($order, 'payment_method'),
                'price_details' => [
                    ['label' => "Biaya Layanan ($staffCount Personel)", 'value' => $unitPrice * $staffCount],
                    ['label' => 'Biaya Platform', 'value' => 5000],
                ],
                'total_price' => $totalPrice,
                'location' => $fullAddress ?? 'Tidak ada alamat',
                'timeline' => [
                    ['time' => Carbon::parse($order['tglOrder'])->format('H:i'), 'desc' => 'Pesanan Dibuat', 'done' => true],
                ],
            ];

            return view('history.detail', ['order' => $mappedOrder]);
        } catch (Exception $e) {
            return redirect()->route('history.index')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function index()
    {
        try {
            $orders = $this->api->getOrderHistory([
                'user_id' => session('user_data')['id'],
            ]);

            $services = $this->api->getServices();
            $serviceMap = [];
            foreach ($services as $s) {
                $serviceMap[$s['id']] = $s['keterangan'];
                if (! empty($s['children'])) {
                    foreach ($s['children'] as $c) {
                        $serviceMap[$c['id']] = $c['keterangan'];
                    }
                }
            }

            // Group orders using the static method
            $groupedOrders = self::groupOrders($orders);

            $pastOrders = [];
            $currentOrders = [];

            foreach ($groupedOrders as $group) {
                $order = $group->first();
                $staffCount = $group->count();
                $statusNum = data_get($order, 'status');

                $type = 'Past';
                if ($statusNum == 63) {
                    $type = 'Present';
                }
                if ($statusNum == 62) {
                    $type = 'Future';
                }

                $mappedOrder = [
                    'id' => $order['id'],
                    'code' => data_get($order, 'inquiry.kodeInquiry', 'ORD-'.$order['id']),
                    'service' => $serviceMap[$order['idLayanan']] ?? 'Layanan #'.$order['idLayanan'],
                    'job_type' => ($serviceMap[$order['idSubLayanan']] ?? 'Jenis Pekerjaan')." ($staffCount Personel)",
                    'date' => data_get($order, 'tglPekerjaan')
                        ? Carbon::parse($order['tglPekerjaan'])->translatedFormat('d M Y, H:i').' WIB'
                        : Carbon::parse($order['tglOrder'])->translatedFormat('d M Y, H:i').' WIB',
                    'status' => $this->getStatusLabel($statusNum),
                    'type' => $type,
                ];

                if ($type === 'Past') {
                    $pastOrders[] = $mappedOrder;
                } else {
                    $currentOrders[] = $mappedOrder;
                }
            }

            return view('history.index', compact('pastOrders', 'currentOrders'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public static function groupOrders($orders)
    {
        return collect($orders)->groupBy(function ($item) {
            return $item['idLayanan'].'-'.$item['idSubLayanan'].'-'.$item['tglPekerjaan'].'-'.$item['idLokasi'];
        });
    }

    protected function getStatusLabel($status)
    {
        return match ((int) $status) {
            64 => 'Selesai',
            63 => 'Pengerjaan',
            62 => 'Dijadwalkan',
            default => 'Diproses',
        };
    }
}
