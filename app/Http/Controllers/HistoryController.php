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
            // Fetch history and filter by ID since a dedicated detail endpoint is unavailable
            $orders = $this->api->getOrderHistory([
                'user_id' => session('user_data')['id'],
            ]);

            $order = collect($orders)->firstWhere('id', $id);

            if (! $order) {
                return redirect()->route('history.index')->withErrors(['error' => 'Pesanan tidak ditemukan.']);
            }

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

            // Map API response to view format
            $mappedOrder = [
                'id' => $order['id'],
                'code' => data_get($order, 'inquiry.kodeInquiry', 'ORD-'.$order['id']),
                'service' => $serviceMap[$order['idLayanan']] ?? 'Layanan #'.$order['idLayanan'],
                'job_type' => $serviceMap[$order['idSubLayanan']] ?? 'Jenis Pekerjaan',
                'status' => $this->getStatusLabel(data_get($order, 'status')),
                'date' => data_get($order, 'tglPekerjaan')
                    ? Carbon::parse($order['tglPekerjaan'])->translatedFormat('d M Y, H:i').' WIB'
                    : Carbon::parse($order['tglOrder'])->translatedFormat('d M Y, H:i').' WIB',
                'payment_method' => data_get($order, 'payment_method'),
                'price_details' => [
                    ['label' => 'Biaya Layanan', 'value' => (float) data_get($order, 'inquiry.finalPrice', 0)],
                    ['label' => 'Biaya Platform', 'value' => 5000],
                ],
                'total_price' => (float) data_get($order, 'inquiry.finalPrice', 0) + 5000,
                'location' => 'Jl. Telomoyo No. 6, Kelurahan Wonotingal, Kecamatan Candisari, Kota Semarang, Provinsi Jawa Tengah',
                'timeline' => [
                    ['time' => Carbon::parse($order['tglOrder'])->format('H:i'), 'desc' => 'Pesanan Dibuat', 'done' => true],
                ],
            ];

            return view('history.detail', ['order' => $mappedOrder]);
        } catch (Exception $e) {
            return redirect()->route('history.index')->withErrors(['error' => 'Gagal mengambil detail pesanan: '.$e->getMessage()]);
        }
    }

    public function index()
    {
        try {
            $orders = $this->api->getOrderHistory([
                'user_id' => session('user_data')['id'],
            ]);

            // Optional: Fetch services to get names
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

            $pastOrders = [];
            $currentOrders = [];

            foreach ($orders as $order) {
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
                    'job_type' => $serviceMap[$order['idSubLayanan']] ?? 'Jenis Pekerjaan',
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
