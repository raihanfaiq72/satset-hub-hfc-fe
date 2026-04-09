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
