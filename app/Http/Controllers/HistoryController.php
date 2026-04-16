<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Carbon\Carbon;

class HistoryController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function show()
    {
        // Dummy Data for Detail Page
        $order = [
            'id' => 12345,
            'code' => 'HFC-2024-003',
            'service' => 'Gardening',
            'job_type' => 'Grass Cutting & Trimming',
            'status' => 'Present',
            'date' => '16 Apr 2026, 09:00',
            'ranger' => [
                'name' => 'Ahmad Ranger',
                'rating' => 4.8,
                'photo' => '👤',
                'description' => 'Ahli pertamanan dengan pengalaman 5 tahun.'
            ],
            'price_details' => [
                ['label' => 'Biaya Layanan', 'value' => 150000],
                ['label' => 'Biaya Platform', 'value' => 5000],
                ['label' => 'Diskon Voucher', 'value' => -10000],
            ],
            'total_price' => 145000,
            'location' => 'Jl. Kebon Jeruk No. 12, Jakarta Barat',
            'timeline' => [
                ['time' => '09:00', 'desc' => 'Pesanan Diterima', 'done' => true],
                ['time' => '09:15', 'desc' => 'Ranger Menuju Lokasi', 'done' => true],
                ['time' => '09:30', 'desc' => 'Pekerjaan Dimulai', 'done' => false],
            ]
        ];

        return view('history.detail', compact('order'));
    }

    public function index()
    {
        try {
            $orders = $this->api->getOrderHistory([
                'user_id' => session('user_data')['id'],
            ]);

            $pastOrders = [];
            $currentOrders = [];

            foreach ($orders as $order) {
                $code = data_get($order, 'inquiry.kodeInquiry', 'ORD-' . $order['id']);
                $service = data_get($order, 'inquiry.kodeInquiry')
                    ? 'Order ' . data_get($order, 'inquiry.kodeInquiry')
                    : 'Layanan #' . data_get($order, 'idLayanan');
                $vendor = data_get($order, 'payment_method', '-');
                $date = data_get($order, 'tglPekerjaan')
                    ? Carbon::parse($order['tglPekerjaan'])->translatedFormat('d M Y H:i')
                    : data_get($order, 'tglOrder');
                $price = data_get($order, 'inquiry.finalPrice', 0) ?: 0;
                $statusText = $this->getStatusLabel(data_get($order, 'status'));

                $mappedOrder = [
                    'id' => $order['id'],
                    'code' => $code,
                    'service' => $service,
                    'vendor' => $vendor,
                    'date' => $date,
                    'price' => $price,
                    'status' => $statusText,
                ];

                if (in_array(data_get($order, 'status'), [64], true)) {
                    $pastOrders[] = $mappedOrder;
                } else {
                    $currentOrders[] = $mappedOrder;
                }
            }

            return view('history.index', compact('pastOrders', 'currentOrders'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    protected function getStatusLabel($status)
    {
        return match ($status) {
            64 => 'Selesai',
            63 => 'Dalam Proses',
            62 => 'Menunggu Konfirmasi',
            default => 'Diproses',
        };
    }
}
