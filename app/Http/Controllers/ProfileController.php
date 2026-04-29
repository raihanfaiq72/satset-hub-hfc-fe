<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use Exception;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        try {
            $response = $this->profileService->getProfile();
            if ($response) {
                // The API returns the customer object directly in 'data'
                session(['user_data' => $response]);
            }
        } catch (Exception $e) {
            return redirect()->route('dashboard')->withErrors(['error' => 'Gagal memuat data profil: '.$e->getMessage()]);
        }

        $user = session('user_data');

        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'noHp' => 'required|string|max:20',
        ]);

        try {
            $data = $request->only(['nama', 'username', 'email', 'noHp']);
            $data['id'] = session('user_data')['id'] ?? session('user_data.id');

            $response = $this->profileService->updateProfile($data);

            if ($response) {
                // Fetch fresh profile after update to ensure session is in sync
                $freshData = $this->profileService->getProfile();
                if ($freshData) {
                    session(['user_data' => $freshData]);
                }

                return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
            }

            return back()->withErrors(['error' => 'Gagal memperbarui profil.'])->withInput();
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
