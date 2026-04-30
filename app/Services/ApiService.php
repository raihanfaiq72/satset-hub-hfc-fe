<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

abstract class ApiService
{
    protected $token;

    public function __construct()
    {
        $this->token = session('api_token');
    }

    protected function request($method, $endpoint, $data = [], $isTokenRequired = true)
    {
        if (! $this->token && $isTokenRequired) {
            throw new \Exception('No API token in session');
        }

        $url = config('services.api_url').'/api/'.$endpoint;

        if (strtolower($method) === 'get') {
            $request = Http::withToken($this->token)->accept('application/json');

            if (! empty($data)) {
                $response = $request->withBody(json_encode($data), 'application/json')->send('GET', $url);
            } else {
                $response = $request->get($url);
            }
        } else {
            $response = Http::withToken($this->token)
                ->accept('application/json')
                ->asJson()
                ->$method($url, $data);
        }

        if (! $response->successful()) {
            $status = $response->status();
            $json = $response->json();

            $message = $json['message'] ?? $json['error'] ?? null;

            // Handle validation errors (422)
            if ($status === 422 && isset($json['errors'])) {
                $errors = [];
                foreach ($json['errors'] as $field => $messages) {
                    foreach ($messages as $msg) {
                        $errors[] = $msg;
                    }
                }
                $message = implode(' ', $errors);
            }

            // Specific handling for 401 (Unauthorized)
            if ($status == 401) {
                session()->forget(['api_token', 'user_data']);
                if (! $message) {
                    $message = 'Sesi Anda telah berakhir atau kredensial tidak valid. Silakan login kembali.';
                }
            }

            if (! $message) {
                $message = "Terjadi kesalahan pada server (HTTP $status).";
            }

            throw new \Exception($message);
        }

        return $response->json()['data'] ?? [];
    }
}
