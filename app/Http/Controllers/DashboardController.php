<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class DashboardController extends Controller{

    public function index(){
        $token = session('api_token');

        if (!$token) {
            return redirect('/login')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
        }

        $response = Http::withToken($token)->get('http://localhost:8000/api/banners');

        if ($response->successful()) {
            $dashboardData = $response->json()['data'] ?? []; 

            return view('dashboard.index', [
                'stats' => $dashboardData,
                'user' => session('user_data') 
            ]);
        }

        if ($response->status() == 401) {
            session()->forget(['api_token', 'user_data']);
            return redirect('/login')->withErrors(['error' => 'Sesi anda telah berakhir.']);
        }

        return view('dashboard')->withErrors(['error' => 'Gagal mengambil data dari server.']);
    }

    public function getBanners(){
        //
    }
}
