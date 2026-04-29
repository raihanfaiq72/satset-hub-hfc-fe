<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use Illuminate\Http\Request;
use Exception;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
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
            $data['id'] = session('user_data')['id'];
            
            $response = $this->profileService->updateProfile($data);

            if ($response) {
                // Update session data
                $userData = session('user_data');
                $userData['nama'] = $request->nama;
                $userData['username'] = $request->username;
                $userData['email'] = $request->email;
                $userData['noHp'] = $request->noHp;
                session(['user_data' => $userData]);

                return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
            }

            return back()->withErrors(['error' => 'Gagal memperbarui profil.'])->withInput();
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
