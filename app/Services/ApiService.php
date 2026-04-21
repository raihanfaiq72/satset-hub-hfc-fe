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

        if ($response->status() == 401) {
            session()->forget(['api_token', 'user_data']);
            throw new \Exception('Unauthorized');
        }

        if (! $response->successful()) {
            $status = $response->status();
            $body = $response->body();
            throw new \Exception("API request failed: HTTP $status - $body");
        }

        return $response->json()['data'] ?? [];
    }
}
