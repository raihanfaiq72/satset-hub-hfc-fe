<?php

namespace App\Services;

class ProfileService extends ApiService
{
    public function updateProfile($data)
    {
        return $this->request('post', 'auth/update-profile', $data);
    }
}
