<?php

namespace App\Services;

class ProfileService extends ApiService
{
    public function getProfile()
    {
        $userId = session('user_data.id');
        if (!$userId) {
            // Try different key if needed
            $userId = session('user_data')['id'] ?? null;
        }
        
        return $this->request('get', 'customer', ['user_id' => $userId]);
    }

    public function updateProfile($data)
    {
        // Use the auth endpoint for updates as seen in backend routes
        return $this->request('post', 'auth/update-profile', $data);
    }
}
